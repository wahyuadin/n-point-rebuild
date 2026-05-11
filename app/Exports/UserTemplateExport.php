<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class UserTemplateExport implements FromArray, WithHeadings, WithTitle
{
    public function array(): array
    {
        // Contoh data baris pertama agar user tahu format isiannya
        return [
            [
                'PRV001',
                'Budi Santoso',
                'budi_admin',
                'budi@example.com',
                'admin',
                '1',
                'password123',
            ],
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
        return 'Template Import User';
    }
}
