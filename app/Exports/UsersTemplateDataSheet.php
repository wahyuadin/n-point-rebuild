<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class UsersTemplateDataSheet implements FromArray, WithHeadings, ShouldAutoSize, WithTitle
{
    public function array(): array
    {
        // Contoh data dummy untuk panduan user
        return [
            [
                'NST-001',
                'M WAHYU ADI NUGROHO',
                'wahyuadin',
                'wahyuadin@nayakaerahusada.com',
                'provider',
                '1',
                'Nayaka@2026',
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'provider_code',
            'nama',
            'username',
            'email',
            'role',
            'is_active',
            'password',
        ];
    }

    public function title(): string
    {
        return 'DATA';
    }
}
