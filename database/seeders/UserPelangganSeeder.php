<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserPelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert Pemilik (USR001)
        DB::table('user')->insert([
            'id_user'    => 'USR001',
            'nama'       => 'Pemilik',
            'email'      => 'pemilik@gmail.com',
            'password'   => Hash::make('123456'),
            'status'     => 1,
            'role'       => 0, // 0 = Pemilik
            'foto'       => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert Admin (USR002)
        DB::table('user')->insert([
            'id_user'    => 'USR002',
            'nama'       => 'Admin',
            'email'      => 'admin@gmail.com',
            'password'   => Hash::make('123456'),
            'status'     => 1,
            'role'       => 1, // 1 = Admin
            'foto'       => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 75 Pelanggan
        $pelangganNames = [
            'Hendra Wijaya',
            'Lestari Anjani',
            'Fajar Pratama',
            'Nina Kartika',
            'Bagus Saputra',
            'Rina Marlina',
            'Dedi Kusuma',
            'Siti Aminah',
            'Asep Nugraha',
            'Putri Maharani',
            'Ilham Ramadhan',
            'Melati Ayu',
            'Andi Firmansyah',
            'Tari Nuraini',
            'Galih Santoso',
            'Dian Septiani',
            'Reza Maulana',
            'Sari Indah',
            'Ahmad Fauzi',
            'Lina Rosalina',
            'Rizky Ananda',
            'Wulan Sari',
            'Bambang Hartono',
            'Citra Lestari',
            'Heri Kurniawan',
            'Desi Ratnasari',
            'Yoga Prasetya',
            'Yuniar Hidayat',
            'Vera Agustina',
            'Anton Syahputra',
            'Nadia Kusumawardani',
            'Joko Santoso',
            'Amelia Zahra',
            'Budi Gunawan',
            'Selvi Andriani',
            'Bayu Nugroho',
            'Eka Purnama',
            'Lukman Hakim',
            'Ratna Dewi',
            'Fikri Anshari',
            'Herlina Marwah',
            'Teguh Prakoso',
            'Della Maharani',
            'Irfan Ramadhan',
            'Salsabila Fitri',
            'Danu Setiawan',
            'Nur Aini',
            'Rangga Saputra',
            'Yohana Kristina',
            'Agus Susanto',
            'Dewi Sartika',
            'Hafiz Maulana',
            'Nina Arifin',
            'Anwar Fadli',
            'Rani Oktaviani',
            'Farhan Yusuf',
            'Maya Putri',
            'Kevin Hidayat',
            'Shinta Permata',
            'Randy Gunawan',
            'Yuliana Sari',
            'Ferry Santoso',
            'Zahra Nuraini',
            'Arif Kurniawan',
            'Mega Rachmawati',
            'Dicky Saputra',
            'Indah Yuliana',
            'Arman Setiawan',
            'Tiara Ramadhani',
            'Fauzan Hakim',
            'Cindy Marlina',
            'Rehan Maulana',
            'Evi Susanti',
            'Gilbert Salim',
            'Aulia Dwi Putri'
        ];

        $users = [];
        $pelanggan = [];

        foreach ($pelangganNames as $index => $name) {
            $userId = 'USR' . str_pad($index + 3, 3, '0', STR_PAD_LEFT); // USR003 - USR077
            $pelangganId = 'PLG' . str_pad($index + 1, 3, '0', STR_PAD_LEFT); // PLG001 - PLG075

            $email = Str::slug($name, '') . '@gmail.com';

            $users[] = [
                'id_user'    => $userId,
                'nama'       => $name,
                'email'      => $email,
                'password'   => Hash::make('123456'),
                'status'     => 1,
                'role'       => 2, // 2 = Pelanggan
                'foto'       => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $pelanggan[] = [
                'id_pelanggan' => $pelangganId,
                'id_user'      => $userId,
                'nama'         => $name,
                'telepon'      => '08' . mt_rand(1000000000, 9999999999),
                'alamat'       => 'Jl. Contoh Alamat No. ' . rand(1, 100),
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }

        DB::table('user')->insert($users);
        DB::table('pelanggan')->insert($pelanggan);
    }
}
