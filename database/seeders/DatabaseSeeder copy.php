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
                'provider_code' => '100802001',
                'nama' => 'RS PRIMAYA PASAR KEMIS',
                'username' => '100802001',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '100802001',
                'nama' => 'RS PRIMAYA PASAR KEMIS',
                'username' => 'admin_primayapk',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
            [
                'provider_code' => '100804025',
                'nama' => 'PRIMAYA HOSPITAL PGI CIKINI',
                'username' => '100804025',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '100804025',
                'nama' => 'PRIMAYA HOSPITAL PGI CIKINI',
                'username' => 'admin_primayack',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
            [
                'provider_code' => '100804076',
                'nama' => 'RS PRIMAYA TANGERANG',
                'username' => '100804076',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '100804076',
                'nama' => 'RS PRIMAYA TANGERANG',
                'username' => 'admin_primayatg',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
            [
                'provider_code' => '124000934',
                'nama' => 'RS PRIMAYA HERTASNING MAKASAR',
                'username' => 'admin_primayahm',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
            [
                'provider_code' => '423000574',
                'nama' => 'RS PRIMAYA BHAKTI WARA',
                'username' => 'admin_primayabw',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
            [
                'provider_code' => '621000287',
                'nama' => 'RS PRIMAYA KARAWANG',
                'username' => 'admin_primayakr',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
            [
                'provider_code' => '1019000051',
                'nama' => 'RS PRIMAYA HOSPITAL BEKASI UTARA',
                'username' => 'admin_primayabu',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
            [
                'provider_code' => '1121000314',
                'nama' => 'RS PRIMAYA SUKABUMI ',
                'username' => 'admin_primayasb',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
            [
                'provider_code' => '1121000315',
                'nama' => 'RS PRIMAYA SEMARANG',
                'username' => 'admin_primayasm',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
            [
                'provider_code' => '010-0074',
                'nama' => 'RS PRIMAYA EVASARI',
                'username' => '010-0074',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '010-0074',
                'nama' => 'RS PRIMAYA EVASARI',
                'username' => 'admin_primayaev',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
            [
                'provider_code' => '010-0226',
                'nama' => 'RS PRIMAYA HOSPITAL TANGERANG',
                'username' => '010-0226',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '011-0033',
                'nama' => 'RS PRIMAYA HOSPITAL BEKASI BARAT',
                'username' => '011-0033',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '011-0033',
                'nama' => 'RS PRIMAYA HOSPITAL BEKASI BARAT',
                'username' => 'AWALBROSBB1',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '011-0033',
                'nama' => 'RS PRIMAYA HOSPITAL BEKASI BARAT',
                'username' => 'AWALBROSBB2',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '011-0033',
                'nama' => 'RS PRIMAYA HOSPITAL BEKASI BARAT',
                'username' => 'AWALBROSBB3',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '011-0033',
                'nama' => 'RS PRIMAYA HOSPITAL BEKASI BARAT',
                'username' => 'AWALBROSBB4',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '011-0033',
                'nama' => 'RS PRIMAYA HOSPITAL BEKASI BARAT',
                'username' => 'AWALBROSBB5',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '011-0033',
                'nama' => 'RS PRIMAYA HOSPITAL BEKASI BARAT',
                'username' => 'AWALBROSBB6',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '011-0033',
                'nama' => 'RS PRIMAYA HOSPITAL BEKASI BARAT',
                'username' => 'AWALBROSBB99',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '011-0033',
                'nama' => 'RS PRIMAYA HOSPITAL BEKASI BARAT',
                'username' => 'admin_primayabb',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
            [
                'provider_code' => '011-0109',
                'nama' => 'RS PRIMAYA HOSPITAL BEKASI TIMUR ',
                'username' => '011-0109',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '011-0109',
                'nama' => 'RS PRIMAYA HOSPITAL BEKASI TIMUR ',
                'username' => 'AWALBROSBT1',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '011-0109',
                'nama' => 'RS PRIMAYA HOSPITAL BEKASI TIMUR ',
                'username' => 'AWALBROSBT2',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '011-0109',
                'nama' => 'RS PRIMAYA HOSPITAL BEKASI TIMUR ',
                'username' => 'AWALBROSBT3',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '011-0109',
                'nama' => 'RS PRIMAYA HOSPITAL BEKASI TIMUR ',
                'username' => 'AWALBROSBT4',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '011-0109',
                'nama' => 'RS PRIMAYA HOSPITAL BEKASI TIMUR ',
                'username' => 'AWALBROSBT5',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '011-0109',
                'nama' => 'RS PRIMAYA HOSPITAL BEKASI TIMUR ',
                'username' => 'AWALBROSBT6',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '011-0109',
                'nama' => 'RS PRIMAYA HOSPITAL BEKASI TIMUR ',
                'username' => 'AWALBROSBT99',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '011-0109',
                'nama' => 'RS PRIMAYA HOSPITAL BEKASI TIMUR ',
                'username' => 'admin_primayabt',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
            [
                'provider_code' => '011-0117',
                'nama' => 'RS PRIMAYA HOSPITAL BETANG PAMBELUM',
                'username' => 'admin_primayabp',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin_12345'),
            ],
            [
                'provider_code' => '019-0014',
                'nama' => 'RS PRIMAYA MAKASAR EX RS AWALBROS',
                'username' => '019-0014',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '019-0014',
                'nama' => 'RS PRIMAYA MAKASAR EX RS AWALBROS',
                'username' => 'admin_primayamk',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
            [
                'provider_code' => '2a',
                'nama' => 'RS. PRIMAYA INCO SUROWAKO',
                'username' => '2a',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('12345678'),
            ],
            [
                'provider_code' => '2a',
                'nama' => 'RS. PRIMAYA INCO SUROWAKO',
                'username' => 'admin_primayasr',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
            [
                'provider_code' => '2a',
                'nama' => 'RS. PRIMAYA INCO SUROWAKO',
                'username' => 'admin_primaya2',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
            [
                'provider_code' => '126001649',
                'nama' => 'RS PRIMAYA FMC',
                'username' => 'primaya_fmc1',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
            [
                'provider_code' => '126001649',
                'nama' => 'RS PRIMAYA FMC',
                'username' => 'primaya_fmc2',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
            [
                'provider_code' => '126001648',
                'nama' => 'RS PRIMAYA KELAPA GADING',
                'username' => 'primaya_kg1',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
            [
                'provider_code' => '126001648',
                'nama' => 'RS PRIMAYA KELAPA GADING',
                'username' => 'primaya_kg2',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
            [
                'provider_code' => '126001647',
                'nama' => 'RS PRIMAYA RAJAWALI',
                'username' => 'admin_primayaR1',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
            [
                'provider_code' => '126001647',
                'nama' => 'RS PRIMAYA RAJAWALI',
                'username' => 'admin_primayaR2',
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('Admin-12345'),
            ],
        ];

        DB::beginTransaction();
        foreach (array_chunk($data, 500) as $chunk) {
            DB::table('users')->insert($chunk);
        }
        DB::commit();
    }
}
