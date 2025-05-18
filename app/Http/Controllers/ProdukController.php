<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $produk = Produk::orderBy('id_produk', 'asc')->get();
        return view('backend.v_produk.index', [
            'judul' => 'Produk',
            'user' => $user,
            'index' => $produk
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $menu = Menu::orderBy('id_menu', 'asc')->get(); // misal model kategori menu
        return view('backend.v_produk.create', [
            'judul' => 'Tambah Produk',
            'user' => $user,
            'menu' => $menu
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'menu_id' => 'required|exists:menu,id_menu',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required',
        ]);

        $namaFoto = time() . '.' . $request->foto->extension();
        $request->foto->storeAs('image/produk', $namaFoto, 'public');

        // Cari produk terakhir berdasarkan menu yang sama
        $lastProduct = Produk::orderBy('id_produk', 'desc')->first();

        if ($lastProduct) {
            $lastNumber = (int) substr($lastProduct->id_produk, 3); // Ambil nomor urut
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        // Buat ID Produk baru
        $newId = 'PRD' . str_pad($newNumber, 3, '0', STR_PAD_LEFT); // PRD01000, PRD02000, dst

        Produk::create([
            'id_produk' => $newId,
            'nama' => $request->nama,
            'id_menu' => $request->menu_id,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'foto' => $namaFoto,
            'status' => $request->status,
        ]);

        return redirect()->route('backend.produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $produk = Produk::findOrFail($id);
        $menu = Menu::orderBy('id_menu', 'asc')->get(); // misal model kategori menu
        return view('backend.v_produk.edit', [
            'judul' => 'Edit Produk',
            'user' => $user,
            'produk' => $produk,
            'menu' => $menu
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'id_menu' => 'required|exists:menu,id_menu',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'status' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->nama = $request->nama;
        $produk->id_menu = $request->id_menu;
        $produk->deskripsi = $request->deskripsi;
        $produk->harga = $request->harga;
        $produk->status = $request->status;

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($produk->foto && file_exists(storage_path('image/produk/' . $produk->foto))) {
                unlink(storage_path('image/produk/' . $produk->foto));
            }

            // Simpan foto baru
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('image/produk', $filename, 'public');
            $produk->foto = $filename;
        }

        $produk->save();

        return redirect()->route('backend.produk.index')->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('backend.produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
