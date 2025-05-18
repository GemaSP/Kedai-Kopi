<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $pemesananList = Pemesanan::with('user')->orderBy('created_at', 'desc')->get();
        return view('backend.v_pemesanan.index', [
            'judul' => 'Pemesanan',
            'user' => $user,
            'pemesananList' => $pemesananList,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Auth::user();
        $pemesanan = Pemesanan::with(['user', 'item_pemesanan.produk'])->findOrFail($id);

        return view('backend.v_pemesanan.show', [
            'judul' => 'Detail Pemesanan',
            'user' => $user,
            'pemesanan' => $pemesanan,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function konfirmasi(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        if ($pemesanan->status == 1) {
            $pemesanan->update([
                'status' => 2, // Status Diproses
            ]);

            return redirect()->route('backend.pemesanan.index')->with('success', 'Pesanan telah dikonfirmasi.');
        }

        return redirect()->route('backend.pemesanan.index')->with('error', 'Status pesanan tidak sesuai.');
    }

    public function kirim(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        if ($pemesanan->status == 2) {
            $pemesanan->update([
                'status' => 3, // Status Dikirim
            ]);

            return redirect()->route('backend.pemesanan.index')->with('success', 'Pesanan telah dikirim.');
        }

        return redirect()->route('backend.pemesanan.index')->with('error', 'Status pesanan tidak sesuai.');
    }

    public function selesai(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        if ($pemesanan->status == 3) {
            $pemesanan->update([
                'status' => 4, // Status Selesai
            ]);

            return redirect()->route('backend.pemesanan.index')->with('success', 'Pesanan telah selesai.');
        }

        return redirect()->route('backend.pemesanan.index')->with('error', 'Status pesanan tidak sesuai.');
    }

    public function batalkan(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        if ($pemesanan->status != 4 && $pemesanan->status != 5) {
            $pemesanan->update([
                'status' => 5, // Status Dibatalkan
            ]);

            return redirect()->route('backend.pemesanan.index')->with('success', 'Pesanan telah dibatalkan.');
        }

        return redirect()->route('backend.pemesanan.index')->with('error', 'Pesanan tidak bisa dibatalkan.');
    }
}
