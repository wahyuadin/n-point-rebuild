<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $data =
        [
            [
                'provider_code' => 'all',
                'nama' => 'IT NAYAKA HO',
                'username' => 'nayaka',
                'password' => bcrypt('pusat@54321'),
                'email' => 'pusat@nayakaerahusada.com',
                'role' => 'admin',
            ],

        ];

        DB::beginTransaction();
        foreach (array_chunk($data, 500) as $chunk) {
            DB::table('users')->insert($chunk);
        }
        DB::commit();
    }
}
