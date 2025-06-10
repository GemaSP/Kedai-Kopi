<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user) {
            return back()
                ->with('gagal', 'Email tidak terdaftar.')
                ->withInput();
        }

        if (!Hash::check($validatedData['password'], $user->password)) {
            return back()
                ->with('gagal', 'Password salah.')
                ->withInput();
        }

        if (!in_array($user->role, [0, 1])) {
            return back()
                ->with('gagal', 'Anda tidak memiliki hak untuk mengakses halaman ini.');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('backend/dashboard')
            ->with('Sukses', 'Berhasil login.');
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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withInput() // agar email tetap terisi
                ->with('Gagal', 'Email tidak terdaftar');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withInput()
                ->with('Gagal', 'Password salah');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('frontend.home');
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
                'email' => 'required|email',
                'password' => 'required',
                'telp' => 'required|numeric',
                'alamat' => 'required'
            ],
            [
                'email.required' => 'Email tidak boleh kosong',
            ]
        );

        // Cek apakah email sudah digunakan
        if (User::where('email', $request->email)->exists()) {
            return back()->withInput()->with('Gagal', 'Email sudah terdaftar');
        }

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
