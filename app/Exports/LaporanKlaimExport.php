<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents; // Hapus WithColumnFormatting
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat; // WAJIB DI-IMPORT

class LaporanKlaimExport implements FromCollection, WithEvents, WithHeadings, WithMapping
{
    protected $dari;
    protected $sampai;
    protected $providerName;
    protected $providerCode;
    protected $selectedColumns;
    private $rowNumber = 0;

    protected $masterColumns = [
        'claim_no'    => 'No Klaim',
        'st_claim'    => 'Status',
        'nm_plan'     => 'Manfaat',
        'st_rujuk'    => 'Rujukan',
        'member_name' => 'Nama Peserta',
        'birth_date'  => 'Tanggal Lahir',
        'nm_cus'      => 'Nama Perusahaan',
        'member_no'   => 'No Kartu',
        'ttl_paid'    => 'Total Biaya',
        'createddate' => 'Tgl Kunjungan',
    ];

    public function __construct($dari = null, $sampai = null, $selectedColumns = [])
    {
        $this->sampai = $sampai ?? now()->format('Y-m-d');
        $this->dari = $dari ?? now()->subDays(60)->format('Y-m-d');
        $this->providerCode = Auth::user()->provider_code;
        $this->providerName = DB::table('tbl_provider')
            ->where('provider_code', $this->providerCode)
            ->value('provider_name');

        $this->selectedColumns = empty($selectedColumns) ? array_keys($this->masterColumns) : $selectedColumns;
    }

    public function collection()
    {
        $query = DB::table('tbl_claim AS c')
            ->join('tbl_claim_detail AS cd', 'c.claim_no', '=', 'cd.claim_no')
            ->join('tbl_membership AS m', 'c.member_no', '=', 'm.member_no')
            ->join('tbl_plan AS p', 'p.kd_plan', '=', 'c.kd_plan')
            ->join('tbl_customer AS cust', 'cust.kd_cus', '=', 'c.kd_cus');

        if (Auth::user()->role !== 'admin') {
            $query->where('c.provider_code', $this->providerCode);
        }

        $query->whereBetween('c.createddate', [
            $this->dari . ' 00:00:00',
            $this->sampai . ' 23:59:59',
        ])->where('c.st_claim', '200');

        return $query->select(
            'c.claim_no',
            'c.st_claim',
            'p.nm_plan',
            'c.st_rujuk',
            'm.member_name',
            'm.birth_date',
            'cust.nm_cus',
            'm.member_no',
            DB::raw('SUM(cd.ttl_paid) as ttl_paid'),
            'c.createddate'
        )
            ->groupBy(
                'c.claim_no',
                'c.st_claim',
                'p.nm_plan',
                'c.st_rujuk',
                'm.member_name',
                'm.birth_date',
                'cust.nm_cus',
                'm.member_no',
                'c.createddate'
            )->get();
    }

    public function map($row): array
    {
        $this->rowNumber++;
        $data = [$this->rowNumber];

        foreach ($this->selectedColumns as $col) {
            $value = $row->$col;

            // 1. Format Tanggal Lahir menjadi "1996-09-20"
            if ($col === 'birth_date' && !empty($value)) {
                $value = date('Y-m-d', strtotime($value));
            }

            // 2. Ubah tipe data string angka menjadi Number asli di PHP
            if (in_array($col, ['claim_no', 'st_claim', 'member_no'])) {
                // Trik `+ 0` akan secara otomatis mengonversi string ke int/float
                $value = is_numeric($value) ? $value + 0 : $value;
            }

            $data[] = $value;
        }

        return $data;
    }

    public function headings(): array
    {
        $headers = ['NO'];
        foreach ($this->selectedColumns as $col) {
            $headers[] = $this->masterColumns[$col];
        }
        return $headers;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                $totalColumnsCount = count($this->selectedColumns) + 1;
                $lastColLetter = Coordinate::stringFromColumnIndex($totalColumnsCount);

                $sheet->insertNewRowBefore(1, 4);

                $sheet->setCellValue('A1', 'REPORT N-POINT');
                $sheet->setCellValue('A2', 'Nama Provider : ' . $this->providerName);
                $sheet->setCellValue('A3', 'Periode : ' . $this->dari . ' s/d ' . $this->sampai);

                $sheet->mergeCells("A1:{$lastColLetter}1");
                $sheet->mergeCells("A2:{$lastColLetter}2");
                $sheet->mergeCells("A3:{$lastColLetter}3");

                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2:A3')->getFont()->setBold(true);

                $sheet->getStyle("A5:{$lastColLetter}5")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['argb' => 'FF9BC2E6'],
                    ],
                ]);

                // Hitung ulang tertinggi setelah insert row
                $highestRow += 4;
                $borderEndRow = $highestRow;

                $ttlPaidIndex = array_search('ttl_paid', $this->selectedColumns);

                if ($highestRow >= 6 && $ttlPaidIndex !== false) {
                    $totalRow = $highestRow + 1;
                    $borderEndRow = $totalRow;

                    $ttlPaidColNum = $ttlPaidIndex + 2;
                    $ttlPaidLetter = Coordinate::stringFromColumnIndex($ttlPaidColNum);
                    $prevLetter = Coordinate::stringFromColumnIndex($ttlPaidColNum - 1);

                    $sheet->setCellValue("{$prevLetter}{$totalRow}", 'GRAND TOTAL');
                    $sheet->setCellValue("{$ttlPaidLetter}{$totalRow}", "=SUM({$ttlPaidLetter}6:{$ttlPaidLetter}{$highestRow})");

                    $sheet->getStyle("A{$totalRow}:{$lastColLetter}{$totalRow}")->getFont()->setBold(true);
                    $sheet->getStyle("{$prevLetter}{$totalRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                    // Format Total Biaya
                    $sheet->getStyle("{$ttlPaidLetter}6:{$ttlPaidLetter}{$totalRow}")
                        ->getNumberFormat()
                        ->setFormatCode('#,##0');
                }

                // Terapkan border
                $sheet->getStyle("A5:{$lastColLetter}{$borderEndRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // 🔥 FORCE EXCEL FORMAT: Mencegah 'General' dan memastikan Ribbon membaca sebagai 'Number'
                $colIndex = 2; // Mulai dari kolom B
                foreach ($this->selectedColumns as $col) {
                    $letter = Coordinate::stringFromColumnIndex($colIndex);

                    // Terapkan NumberFormat HANYA untuk baris data (6 sampai bawah)
                    if (in_array($col, ['claim_no', 'st_claim', 'member_no'])) {
                        $sheet->getStyle("{$letter}6:{$letter}{$highestRow}")
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_NUMBER); // KODE '0' (Number murni)
                    }

                    $sheet->getColumnDimension($letter)->setAutoSize(true);
                    $colIndex++;
                }

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->freezePane('A6');
                $sheet->setAutoFilter("A5:{$lastColLetter}{$highestRow}");
            },
        ];
    }
}
