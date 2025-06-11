<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    // Tampilkan form input tanggal laporan
    public function index()
    {
        return view('backend.v_laporan.index', [
            'judul' => 'Laporan Penjualan',
            'user' => Auth::user()
        ]);
    }

    // Proses dan tampilkan hasil laporan berdasarkan rentang tanggal
    public function cetak(Request $request)
    {
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        // Ambil data pemesanan dengan status pembayaran 'Sukses'
        $pemesanan = DB::table('pemesanan')
            ->join('transaksi', 'pemesanan.id_pemesanan', '=', 'transaksi.id_pemesanan')
            ->where('transaksi.status_pembayaran', 'Sukses')
            ->whereBetween('pemesanan.created_at', [$tanggal_awal . ' 00:00:00', $tanggal_akhir . ' 23:59:59'])
            ->select('pemesanan.*') // hanya ambil kolom dari pemesanan
            ->get();

        if ($pemesanan->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada data transaksi pada rentang tanggal tersebut.'
            ]);
        }

        // Total transaksi & pendapatan
        $totalTransaksi = $pemesanan->count();
        $totalPendapatan = $pemesanan->sum('total_harga');

        // Metode pembayaran
        $cashless = $pemesanan->filter(fn($item) => str_contains($item->metode_pembayaran, 'Cashless'))->count();
        $cod = $pemesanan->filter(fn($item) => str_contains($item->metode_pembayaran, 'COD'))->count();

        // Ringkasan harian
        $rekapHarian = DB::table('pemesanan')
            ->join('transaksi', 'pemesanan.id_pemesanan', '=', 'transaksi.id_pemesanan')
            ->where('transaksi.status_pembayaran', 'Sukses')
            ->whereBetween('pemesanan.created_at', [$tanggal_awal, $tanggal_akhir])
            ->select(
                DB::raw('DATE(pemesanan.created_at) as tanggal'),
                DB::raw('COUNT(*) as jumlah_transaksi'),
                DB::raw('SUM(pemesanan.total_harga) as total_penjualan')
            )
            ->groupBy(DB::raw('DATE(pemesanan.created_at)'))
            ->orderBy('tanggal')
            ->get();

        // Produk terlaris
        $produkTerlaris = DB::table('item_pemesanan')
            ->join('produk', 'item_pemesanan.id_produk', '=', 'produk.id_produk')
            ->join('pemesanan', 'item_pemesanan.id_pemesanan', '=', 'pemesanan.id_pemesanan')
            ->join('transaksi', 'pemesanan.id_pemesanan', '=', 'transaksi.id_pemesanan')
            ->where('transaksi.status_pembayaran', 'Sukses')
            ->whereBetween('pemesanan.created_at', [$tanggal_awal, $tanggal_akhir])
            ->select('produk.nama', DB::raw('SUM(item_pemesanan.quantity) as terjual'), DB::raw('SUM(item_pemesanan.total) as total'))
            ->groupBy('produk.nama')
            ->orderByDesc('terjual')
            ->limit(5)
            ->get();

        // Daftar transaksi detail
        $transaksiDetail = DB::table('pemesanan')
            ->join('user', 'pemesanan.id_user', '=', 'user.id_user')
            ->join('transaksi', 'pemesanan.id_pemesanan', '=', 'transaksi.id_pemesanan')
            ->where('transaksi.status_pembayaran', 'Sukses')
            ->whereBetween('pemesanan.created_at', [$tanggal_awal, $tanggal_akhir])
            ->select('pemesanan.*', 'user.nama as nama_user')
            ->get()
            ->map(function ($p) {
                $items = DB::table('item_pemesanan')
                    ->join('produk', 'item_pemesanan.id_produk', '=', 'produk.id_produk')
                    ->where('item_pemesanan.id_pemesanan', $p->id_pemesanan)
                    ->get();

                return (object)[
                    'tanggal' => Carbon::parse($p->created_at)->format('d-m-Y'),
                    'pelanggan' => $p->nama_user,
                    'produk' => $items->pluck('nama')->implode(', '),
                    'qty' => $items->sum('quantity'),
                    'total' => $p->total_harga,
                    'metode' => $p->metode_pembayaran,
                    'status' => 'Sukses',
                ];
            });

        // Statistik
        $statistik = [
            'rata2_per_hari' => round($totalTransaksi / max($rekapHarian->count(), 1)),
            'tertinggi' => $rekapHarian->max('total_penjualan'),
            'tanggal_tertinggi' => $rekapHarian->sortByDesc('total_penjualan')->first()->tanggal ?? '-',
            'jam_ramai' => '09.00 - 11.00',
        ];

        $judul = 'Laporan Penjualan';
        $user = Auth::user();

        $pdf = Pdf::loadView('backend.v_laporan.laporan_cetak', compact(
            'judul',
            'user',
            'tanggal_awal',
            'tanggal_akhir',
            'totalTransaksi',
            'totalPendapatan',
            'cashless',
            'cod',
            'rekapHarian',
            'produkTerlaris',
            'transaksiDetail',
            'statistik'
        ))->setPaper('A4', 'portrait');

        // Tampilkan langsung di browser
        $tanggalAwalFormatted = Carbon::parse($tanggal_awal)->format('d-m-Y');
        $tanggalAkhirFormatted = Carbon::parse($tanggal_akhir)->format('d-m-Y');
        $filename = "Laporan Penjualan dari {$tanggalAwalFormatted} sd {$tanggalAkhirFormatted}.pdf";

        return $pdf->download($filename);

        // atau jika mau langsung download:
        // return $pdf->download('laporan_penjualan.pdf');

    }
}
