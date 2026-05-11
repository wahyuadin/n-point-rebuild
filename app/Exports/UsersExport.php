<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $columns;

    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    public function collection()
    {
        return User::latest()->get();
    }

    public function headings(): array
    {
        $listHeadings = [
            'provider_code' => 'Provider Code',
            'nama'          => 'Nama Lengkap',
            'username'      => 'Username',
            'email'         => 'Email',
            'role'          => 'Role',
            'is_active'     => 'Status',
            'created_at'    => 'Tanggal Dibuat',
        ];

        $headers = [];
        foreach ($this->columns as $col) {
            $headers[] = $listHeadings[$col] ?? ucfirst($col);
        }

        return $headers;
    }

    public function map($user): array
    {
        $data = [];
        foreach ($this->columns as $col) {
            if ($col == 'is_active') {
                $data[] = $user->is_active ? 'Aktif' : 'Non-Aktif';
            } elseif ($col == 'created_at') {
                $data[] = $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : '-';
            } else {
                $data[] = $user->{$col};
            }
        }

        return $data;
    }
}
