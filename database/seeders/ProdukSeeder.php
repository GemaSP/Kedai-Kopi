<?php

namespace Database\Seeders;

use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar harga yang diperbolehkan
        $hargaList = [15000, 18000, 20000, 21000, 22000, 23000];

        // Produk per menu
        $produkPerMenu = [
            'MN01' => [
                'Americano',
                'Espresso',
                'Latte',
                'Cappuccino',
                'Mocha',
                'Macchiato'
            ],
            'MN02' => [
                'Caramel Frappuccino',
                'Mocha Frappuccino',
                'Java Chip',
                'Matcha Blend',
                'Vanilla Cream',
                'Strawberry Cream'
            ],
            'MN03' => [
                'Green Tea',
                'Black Tea',
                'Oolong Tea',
                'Chamomile',
                'Earl Grey',
                'Lemon Mint'
            ],
            'MN04' => [
                'Croissant',
                'Donut',
                'Sandwich',
                'Muffin',
                'Pasta',
                'Quiche'
            ]
        ];

        $counter = 1;
        foreach ($produkPerMenu as $idMenu => $produkList) {
            foreach ($produkList as $produk) {
                $idProduk = 'PRD' . str_pad($counter, 3, '0', STR_PAD_LEFT);
                DB::table('produk')->insert([
                    'id_produk'  => $idProduk,
                    'id_menu'    => $idMenu,
                    'nama'       => $produk,
                    'deskripsi'  => 'Deskripsi dari ' . $produk,
                    'harga'      => $hargaList[array_rand($hargaList)],
                    'foto'       => null,
                    'status'     => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                $counter++;
            }
        }
    }
}
