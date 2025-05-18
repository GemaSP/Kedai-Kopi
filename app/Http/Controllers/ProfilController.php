<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return view('backend.v_profil.index', [
            'judul' => 'Profil',
            'user' => $user,
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
        // Cari user berdasarkan ID yang diberikan
        $user = User::findOrFail($id); // Cari user berdasarkan ID atau error jika tidak ditemukan

        // Validasi input
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi foto
        ]);

        // Jika ada foto yang diunggah
        if ($request->hasFile('foto')) {
            // Cek apakah sebelumnya ada foto dan hapus foto lama
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            // Simpan foto baru dan ambil pathnya
            $photoName = time() . '.' . $request->foto->extension();
            $request->foto->storeAs('image/foto-profil', $photoName, 'public');
            $data['foto'] = $photoName; // Simpan nama foto baru ke array data
        }




        // Simpan perubahan ke database
        $update = User::where('id_user', $id)->update($data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
