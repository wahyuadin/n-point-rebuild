<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UsersImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    protected $mapping;

    public function __construct(array $mapping)
    {
        $this->mapping = $mapping;
    }

    public function collection(Collection $rows)
    {
        $validProviderCodes = DB::table('tbl_provider')->pluck('provider_code')->toArray();
        foreach ($rows as $row) {
            $keyProvider = $this->mapping['provider_code'] ?? null;
            $keyNama     = $this->mapping['nama'] ?? null;
            $keyUsername = $this->mapping['username'] ?? null;
            $keyEmail    = $this->mapping['email'] ?? null;
            $keyRole     = $this->mapping['role'] ?? null;
            $keyActive   = $this->mapping['is_active'] ?? null;
            $keyPassword = $this->mapping['password'] ?? null;

            $nama     = isset($row[$keyNama]) ? $row[$keyNama] : null;
            $username = isset($row[$keyUsername]) ? $row[$keyUsername] : null;
            $providerCode = isset($row[$keyProvider]) ? trim($row[$keyProvider]) : null;

            if (is_string($nama)) $nama = trim($nama);
            if (is_string($username)) $username = trim($username);

            if ($nama === null || $nama === '' || $username === null || $username === '') {
                continue;
            }

            if (!in_array($providerCode, $validProviderCodes)) {
                throw new \Exception("Provider Code '{$providerCode}' untuk user '{$nama}' tidak terdaftar di sistem.");
            }

            User::create([
                'provider_code' => $providerCode,
                'nama'          => $nama,
                'username'      => $username,
                'email'         => isset($row[$keyEmail]) ? $row[$keyEmail] : null,
                'role'          => (isset($row[$keyRole]) && !empty($row[$keyRole])) ? strtolower(trim($row[$keyRole])) : 'provider',
                'is_active'     => (isset($row[$keyActive]) && $row[$keyActive] !== '') ? $row[$keyActive] : 1,
                'password'      => Hash::make((isset($row[$keyPassword]) && !empty($row[$keyPassword])) ? $row[$keyPassword] : 'password123'),
            ]);
        }
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }
}
