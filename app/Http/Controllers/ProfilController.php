<?php

namespace App\Http\Controllers;

use App\Models\ItemKeranjang;
use App\Models\Keranjang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function profilSaya()
    {
        $user = Auth::user(); // user login
        $pelanggan = \App\Models\Pelanggan::where('id_user', $user->id_user)->firstOrFail();
        $keranjang = Keranjang::where('id_user', Auth::user()->id_user)->first();
        $keranjangCount = ItemKeranjang::where('id_keranjang', $keranjang->id_keranjang)->count();

        return view('frontend.v_profile.index', compact('user', 'pelanggan', 'keranjangCount'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:64',
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        $loggedIn = Auth::user();
        $user = User::findOrFail($loggedIn->id_user);
        $pelanggan = \App\Models\Pelanggan::where('id_user', $user->id_user)->firstOrFail();

        $pelanggan->update([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);
        $user->update([
            'nama' => $request->nama,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function gantiPassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ]);

        $user = User::findOrFail(Auth::user()->id_user);

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->with('error', 'Password lama salah.');
        }

        $user->password = Hash::make($request->password_baru);
        $user->save();

        return back()->with('success', 'Password berhasil diubah.');
    }
}
