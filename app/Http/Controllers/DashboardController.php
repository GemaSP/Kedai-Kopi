<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pemesanan;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today(); // Mendapatkan tanggal hari ini
        $jumlahPelanggan = Pelanggan::count(); // Menghitung jumlah pelanggan berdasarkan id_user
        $jumlahPemesanan = Pemesanan::whereDate('created_at', $today)->count();
        // Menghitung total jumlah bayar dari transaksi yang status pembayarannya sukses
        $pendapatanHariIni = Transaksi::whereDate('created_at', $today) // Memfilter berdasarkan tanggal hari ini
            ->where('status_pembayaran', 'Sukses') // Memfilter transaksi dengan status sukses
            ->sum('jumlah_bayar'); // Menjumlahkan kolom jumlah_bayar

        $bulanIni = Carbon::now()->month; // Mendapatkan bulan sekarang
        $tahunIni = Carbon::now()->year;  // Mendapatkan tahun sekarang

        // Menghitung total jumlah bayar dari transaksi yang status pembayarannya sukses bulan ini
        $pendapatanBulanIni = Transaksi::whereMonth('created_at', $bulanIni) // Memfilter berdasarkan bulan ini
            ->whereYear('created_at', $tahunIni)  // Memfilter berdasarkan tahun ini
            ->where('status_pembayaran', 'Sukses') // Memfilter transaksi dengan status sukses
            ->sum('jumlah_bayar'); // Menjumlahkan kolom jumlah_bayar

        // Tambahan untuk grafik 30 hari terakhir
        $tanggalMulai = Carbon::now()->subDays(29)->startOfDay();
        $tanggalAkhir = Carbon::now()->endOfDay();
        $pendapatanHarian = DB::table('transaksi')
            ->select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(jumlah_bayar) as total'))
            ->whereBetween('created_at', [$tanggalMulai, $tanggalAkhir])
            ->where('status_pembayaran', 'Sukses')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('tanggal')
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => Carbon::parse($item->tanggal)->format('d M'),
                    'total' => $item->total,
                ];
            });


        $jumlahPemesananPerMenu = DB::table('item_pemesanan')
            ->join('produk', 'item_pemesanan.id_produk', '=', 'produk.id_produk')
            ->join('menu', 'produk.id_menu', '=', 'menu.id_menu')
            ->join('pemesanan', 'item_pemesanan.id_pemesanan', '=', 'pemesanan.id_pemesanan')
            ->join('transaksi', 'pemesanan.id_pemesanan', '=', 'transaksi.id_pemesanan')
            ->where('transaksi.status_pembayaran', '=', 'Sukses')
            ->select('menu.nama_menu', DB::raw('COUNT(item_pemesanan.id) as total'))
            ->groupBy('menu.nama_menu')
            ->get();

        $topProduk = DB::table('item_pemesanan')
            ->join('produk', 'item_pemesanan.id_produk', '=', 'produk.id_produk')
            ->join('pemesanan', 'item_pemesanan.id_pemesanan', '=', 'pemesanan.id_pemesanan')
            ->join('transaksi', 'pemesanan.id_pemesanan', '=', 'transaksi.id_pemesanan')
            ->where('transaksi.status_pembayaran', 'Sukses')
            ->select('produk.nama', DB::raw('COUNT(item_pemesanan.id) as total_terjual'))
            ->groupBy('produk.nama')
            ->orderByDesc('total_terjual')
            ->limit(10)
            ->get();

        $topPembeli = DB::table('pelanggan')
            ->join('user', 'pelanggan.id_user', '=', 'user.id_user')
            ->join('pemesanan', 'pemesanan.id_user', '=', 'user.id_user')
            ->join('transaksi', 'pemesanan.id_pemesanan', '=', 'transaksi.id_pemesanan')
            ->where('transaksi.status_pembayaran', 'Sukses')
            ->select('pelanggan.nama', DB::raw('COUNT(transaksi.id_transaksi) as total_beli'))
            ->groupBy('pelanggan.nama')
            ->orderByDesc('total_beli')
            ->limit(10)
            ->get();

        return view('backend.v_dashboard.index', [
            'judul' => 'Dashboard',
            'user' => $user,
            'jumlahPelanggan' => $jumlahPelanggan,
            'jumlahPemesanan' => $jumlahPemesanan,
            'pendapatanHariIni' => $pendapatanHariIni,
            'pendapatanBulanIni' => $pendapatanBulanIni,
            'pendapatanHarian' => $pendapatanHarian,
            'jumlahPemesananPerMenu' => $jumlahPemesananPerMenu,
            'topProduk' => $topProduk,
            'topPembeli' => $topPembeli,
        ]);
    }
}
