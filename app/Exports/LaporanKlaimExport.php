<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LaporanKlaimExport implements FromCollection, WithColumnFormatting, WithEvents, WithHeadings, WithMapping
{
    protected $dari;

    protected $sampai;

    protected $providerName;

    protected $providerCode;

    private $rowNumber = 0;

    public function __construct($dari = null, $sampai = null)
    {
        $this->sampai = $sampai ?? now()->format('Y-m-d');
        $this->dari = $dari ?? now()->subDays(60)->format('Y-m-d');
        $this->providerCode = Auth::user()->provider_code;
        $this->providerName = DB::table('tbl_provider')
            ->where('provider_code', $this->providerCode)
            ->value('provider_name');
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
        ]);
        $query->where('c.st_claim', '200');

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
            )
            ->get();
    }

    public function map($row): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $row->claim_no,
            $row->st_claim,
            $row->nm_plan,
            $row->st_rujuk,
            $row->member_name,
            $row->birth_date,
            $row->nm_cus,
            $row->member_no,
            $row->ttl_paid,
            $row->createddate,
        ];
    }

    public function headings(): array
    {
        return [
            'NO',
            'No Klaim',
            'Status',
            'Manfaat',
            'Rujukan',
            'Nama Peserta',
            'Tanggal Lahir',
            'Nama Perusahaan',
            'No Kartu',
            'Total Biaya',
            'Tanggal Kunjungan',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => '0',
            'C' => '0',
            'I' => '0',
            'J' => '#,##0',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                $sheet->insertNewRowBefore(1, 4);

                $sheet->setCellValue('A1', 'REPORT N-POINT');
                $sheet->setCellValue('A2', 'Nama Provider : ' . $this->providerName);
                $sheet->setCellValue('A3', 'Periode : ' . $this->dari . ' s/d ' . $this->sampai);

                $sheet->mergeCells('A1:K1');
                $sheet->mergeCells('A2:K2');
                $sheet->mergeCells('A3:K3');

                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2:A3')->getFont()->setBold(true);

                $highestRow = $sheet->getHighestRow();

                $sheet->getStyle('A5:K5')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['argb' => 'FF9BC2E6'],
                    ],
                ]);

                // 🔥 GRAND TOTAL LOGIC
                // Memastikan ada data sebelum menjumlahkan (baris data dimulai dari row 6)
                if ($highestRow >= 6) {
                    $totalRow = $highestRow + 1;

                    // Set teks label dan formula SUM untuk kolom J (Total Biaya)
                    $sheet->setCellValue('I' . $totalRow, 'GRAND TOTAL');
                    $sheet->setCellValue('J' . $totalRow, '=SUM(J6:J' . $highestRow . ')');

                    // Style untuk baris Grand Total
                    $sheet->getStyle('A' . $totalRow . ':K' . $totalRow)->getFont()->setBold(true);
                    $sheet->getStyle('I' . $totalRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('J' . $totalRow)->getNumberFormat()->setFormatCode('#,##0');

                    // Perbarui highest row untuk border agar mencakup baris Grand Total
                    $borderEndRow = $totalRow;
                } else {
                    $borderEndRow = $highestRow;
                }

                // Terapkan border sampai baris terakhir (termasuk baris Total jika ada)
                $sheet->getStyle('A5:K' . $borderEndRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                foreach (range('A', 'K') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                $sheet->freezePane('A6');

                // Pastikan auto-filter HANYA sampai baris data ($highestRow),
                // agar baris Grand Total tidak ada tombol filternya dan tidak ikut difilter
                $sheet->setAutoFilter('A5:K' . $highestRow);
            },
        ];
    }
}
