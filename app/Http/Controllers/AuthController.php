<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('backend.v_auth.index', [
            'judul' => 'Login'
        ]);
    }

    public function storeLogin(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($validatedData)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if (!in_array($user->role, [0, 1])) {
                Auth::logout();
                return back()->with('gagal', 'Anda tidak memiliki hak untuk mengakses halaman ini.');
            }

            return redirect()->intended('backend/dashboard');
        } else {
            return back()->with('gagal', 'Login gagal. Periksa kembali email dan password Anda.');
        }
    }


    public function registrasi()
    {
        return view('backend.v_auth.registrasi', [
            'judul' => 'Registrasi'
        ]);
    }

    public function storeRegistrasi(Request $request)
    {
        $validatedData = $request->validate(
            [
                'nama' => 'required',
                'email' => 'required|email|unique:user,email',
                'password' => 'required',
                'ulangiPassword' => 'required|same:password'
            ],
            [
                'email.required' => 'Email tidak boleh kosong',
            ]
        );

        // Generate ID: ambil jumlah user saat ini + 1
        $lastUser = User::latest('id_user')->first();
        $nextUserNumber = $lastUser ? (int)substr($lastUser->id_user, 3) + 1 : 1;
        $idUser = 'USR' . str_pad($nextUserNumber, 3, '0', STR_PAD_LEFT);

        // Siapkan data
        $validatedData['id_user'] = $idUser;
        $validatedData['status'] = 1;
        $validatedData['role'] = 1;
        $validatedData['foto'] = 'default.jpg';

        // Simpan ke DB
        User::create($validatedData);

        return redirect()->route('backend.login')->with('Sukses', 'User berhasil dibuat, silakan login');
    }


    public function lupaPassword()
    {
        return view('backend.v_auth.forgotPassword', [
            'judul' => 'Lupa Password'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('backend.login')->with('Sukses', 'Anda berhasil logout');
    }

    public function loginCustomer()
    {
        return view('frontend.v_auth.index');
    }

    public function storeLoginCustomer(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($validatedData)) {
            $request->session()->regenerate();
            return redirect()->route('frontend.home');
        } else {
            return back()->with('Gagal', 'Login Gagal');
        }
    }

    public function registerCustomer()
    {
        return view('frontend.v_auth.register');
    }

    public function storeRegisterCustomer(Request $request)
    {
        $validatedData = $request->validate(
            [
                'nama' => 'required',
                'email' => 'required|email|unique:user,email',
                'password' => 'required',
                'telp' => 'required|numeric',
                'alamat' => 'required'
            ],
            [
                'email.required' => 'Email tidak boleh kosong',
            ]
        );

        // Generate ID User (USR000)
        $lastUser = User::latest('id_user')->first();
        $nextUserNumber = $lastUser ? (int)substr($lastUser->id_user, 3) + 1 : 1;
        $idUser = 'USR' . str_pad($nextUserNumber, 3, '0', STR_PAD_LEFT);

        // Buat user
        User::create([
            'id_user' => $idUser,
            'nama' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'status' => 1,
            'role' => 2,
            'foto' => 'default.jpg'
        ]);

        // Generate ID Pelanggan (PEL000)
        $lastPelanggan = Pelanggan::latest('id_pelanggan')->first();
        $nextPelangganNumber = $lastPelanggan ? (int)substr($lastPelanggan->id_pelanggan, 3) + 1 : 1;
        $idPelanggan = 'PEL' . str_pad($nextPelangganNumber, 3, '0', STR_PAD_LEFT);

        // Buat pelanggan
        Pelanggan::create([
            'id_pelanggan' => $idPelanggan,
            'id_user' => $idUser,
            'nama' => $validatedData['nama'],
            'telepon' => $validatedData['telp'], // Kosong dulu, bisa diupdate nanti
            'alamat' => $validatedData['alamat'],
        ]);

        return redirect()->route('frontend.login')->with('Sukses', 'User berhasil dibuat');
    }

    public function logoutCustomer(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('frontend.login')->with('Sukses', 'Anda berhasil logout');
    }
}
