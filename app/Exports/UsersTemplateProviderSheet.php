<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class UsersTemplateProviderSheet implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle
{
    public function collection()
    {
        return DB::table('tbl_provider')
            ->select('provider_code', 'provider_name')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Provider Code',
            'Provider Name',
        ];
    }

    public function title(): string
    {
        return 'PROVIDER'; // Nama Sheet 2
    }
}
