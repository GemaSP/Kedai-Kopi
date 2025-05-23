<?php

namespace App\Http\Controllers;

use App\Models\ItemKeranjang;
use App\Models\Keranjang;
use App\Models\Pelanggan;
use App\Models\Pemesanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua pesanan user beserta item dan produk-nya
        $pesananList = Pemesanan::where('id_user', $user->id_user)
            ->with(['item_pemesanan.produk', 'transaksi']) // tambahkan relasi transaksi di sini
            ->orderBy('created_at', 'desc')
            ->get();
        $keranjang = Keranjang::where('id_user', Auth::user()->id_user)->first();
        $keranjangCount = ItemKeranjang::where('id_keranjang', $keranjang->id_keranjang)->count();

        return view('frontend.v_pesanan.index', [
            'judul' => 'Pesanan Saya',
            'user' => $user,
            'keranjangCount' => $keranjangCount,
            'pesananList' => $pesananList,
        ]);
    }

    public function konfirmasi($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $transaksi = Transaksi::where('id_pemesanan', $pemesanan->id_pemesanan)->first();

        if ($pemesanan->status == 3) {
            $pemesanan->update([
                'status' => 4,
            ]);
            $transaksi->update([
                'status_pembayaran' => 'Sukses',
            ]);
            return redirect()->route('frontend.pesanan.index')->with('success', 'Pesanan telah dikonfirmasi.');
        }
        return redirect()->route('frontend.pesanan.index')->with('error', 'Status pesanan tidak sesuai.');
    }

    public function batalkan($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $transaksi = Transaksi::where('id_pemesanan', $pemesanan->id_pemesanan)->first();


        if ($pemesanan->status == 1) {
            $pemesanan->update([
                'status' => 5, // Status Dibatalkan
            ]);
            $transaksi->update([
                'status_pembayaran' => 'Gagal',
            ]);

            return redirect()->route('frontend.pesanan.index')->with('success', 'Pesanan telah dibatalkan.');
        }

        return redirect()->route('backend.pesanan.index')->with('error', 'Pesanan tidak bisa dibatalkan.');
    }

    public function show($id)
    {
        $user = Auth::user();
        $pelanggan = Pelanggan::where('id_user', $user->id_user)->first();
        $pesanan = Pemesanan::with(['item_pemesanan.produk', 'transaksi'])
            ->where('id_pemesanan', $id)
            ->where('id_user', $user->id_user)
            ->firstOrFail();
        $keranjang = Keranjang::where('id_user', Auth::user()->id_user)->first();
        $keranjangCount = ItemKeranjang::where('id_keranjang', $keranjang->id_keranjang)->count();
        return view('frontend.v_pesanan.show', compact('pesanan', 'keranjangCount'));
    }
}
