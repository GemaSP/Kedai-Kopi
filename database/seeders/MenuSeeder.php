<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            ['nama' => 'Espresso & Brew Coffe'],
            ['nama' => 'Frapuccino(Blended Beverages)'],
            ['nama' => 'Teavana (Tea)'],
            ['nama' => 'Makanan']
        ];

        $counter = 1;
        foreach ($menus as $menu) {
            $id = 'MN' . str_pad($counter, 2, '0', STR_PAD_LEFT);
            Menu::create([
                'id_menu' => $id,
                'nama_menu' => $menu['nama']
            ]);
            $counter++;
        }
    }
}
