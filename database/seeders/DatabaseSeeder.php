<?php

namespace Database\Seeders;

use App\Models\Pemesanan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserPelangganSeeder::class,
            MenuSeeder::class,
            ProdukSeeder::class,
            PemesananTransaksiSeeder::class,
        ]);
    }
}
