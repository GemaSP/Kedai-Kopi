<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $menu = Menu::orderBy('id_menu', 'asc')->get();
        return view('backend.v_menu.index', [
            'judul' => 'Menu',
            'user' => $user,
            'index' => $menu
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
        // Validasi input
        $request->validate([
            'nama_menu' => 'required|string|max:255',
        ]);

        // Cari ID menu terakhir yang ada
        $lastMenu = Menu::orderBy('id_menu', 'desc')->first();

        // Jika ada data sebelumnya, ambil ID terakhir dan buat ID baru
        if ($lastMenu) {
            // Ambil angka dari ID terakhir, contoh MN01 -> 01
            $lastId = (int) substr($lastMenu->id_menu, 2);
            $newId = 'MN' . str_pad($lastId + 1, 2, '0', STR_PAD_LEFT);
        } else {
            // Jika belum ada data, mulai dengan MN01
            $newId = 'MN01';
        }

        // Simpan data menu baru
        $menu = new Menu();
        $menu->id_menu = $newId;
        $menu->nama_menu = $request->nama_menu;
        $menu->save();

        // Redirect dengan pesan sukses
        return redirect()->route('backend.menu.index')->with('success', 'Menu berhasil ditambahkan!');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'nama_menu' => 'required|string|max:100',
        ]);

        // Cari data menu berdasarkan ID
        $menu = Menu::findOrFail($id);

        // Update nama menu
        $menu->nama_menu = $request->nama_menu;
        $menu->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('backend.menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Menu::where('id_menu', $id)->delete();
        return redirect()->route('backend.menu.index');
    }
}
