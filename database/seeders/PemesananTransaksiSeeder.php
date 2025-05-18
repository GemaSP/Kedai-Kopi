<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemesananTransaksiSeeder extends Seeder
{
    public function run()
    {
        $users = collect(range(3, 77))->map(function ($i) {
            return 'USR' . str_pad($i, 3, '0', STR_PAD_LEFT);
        });

        $produkIds = DB::table('produk')->pluck('id_produk')->toArray();

        $statuses = ['Sukses' => 4, 'Gagal' => 5];

        $dateStart = Carbon::now()->subDays(10);
        $tanggalTransaksi = [];

        for ($i = 1; $i <= 250; $i++) {
            $tanggal = $dateStart->copy()->addDays(rand(0, 10));
            $tanggalFormat = $tanggal->format('dmY');

            // Hitung jumlah transaksi untuk tanggal ini, lalu increment
            if (!isset($tanggalTransaksi[$tanggalFormat])) {
                $tanggalTransaksi[$tanggalFormat] = 1;
            } else {
                $tanggalTransaksi[$tanggalFormat]++;
            }

            $kodeUrut = str_pad($tanggalTransaksi[$tanggalFormat], 3, '0', STR_PAD_LEFT);
            $idPemesanan = 'PSN' . $tanggalFormat . $kodeUrut;
            $idTransaksi = 'TRX' . $tanggalFormat . $kodeUrut;

            $user = $users->random();
            $metode = collect(['COD', 'Cashless'])->random();

            // Status: 90% sukses, 10% gagal
            $statusPembayaran = rand(1, 100) <= 10 ? 'Gagal' : 'Sukses';
            $statusPemesanan = $statuses[$statusPembayaran];

            $ongkir = 10000;
            $produkDipilih = collect($produkIds)->random(rand(1, 3));

            $itemList = [];
            $totalHarga = 0;

            foreach ($produkDipilih as $idProduk) {
                $produk = DB::table('produk')->where('id_produk', $idProduk)->first();
                $qty = rand(1, 3);
                $subTotal = $qty * $produk->harga;

                $itemList[] = [
                    'id_pemesanan' => $idPemesanan,
                    'id_produk' => $idProduk,
                    'quantity' => $qty,
                    'harga_satuan' => $produk->harga,
                    'total' => $subTotal,
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                $totalHarga += $subTotal;
            }

            $totalBayar = $totalHarga + $ongkir;

            // 1. Insert ke pemesanan
            DB::table('pemesanan')->insert([
                'id_pemesanan' => $idPemesanan,
                'id_user' => $user,
                'alamat' => 'Jl. Contoh Alamat No. ' . rand(1, 100),
                'metode_pembayaran' => $metode,
                'ongkir' => $ongkir,
                'total_harga' => $totalBayar,
                'status' => $statusPemesanan,
                'created_at' => $tanggal,
                'updated_at' => $tanggal
            ]);

            // 2. Insert ke item_pemesanan pakai data yang udah dihitung
            DB::table('item_pemesanan')->insert($itemList);

            // 3. Insert ke transaksi
            DB::table('transaksi')->insert([
                'id_transaksi' => $idTransaksi,
                'id_pemesanan' => $idPemesanan,
                'status_pembayaran' => $statusPembayaran,
                'jumlah_bayar' => $totalBayar,
                'invoice_url' => null,
                'created_at' => $tanggal,
                'updated_at' => $tanggal
            ]);
        }
    }
}
