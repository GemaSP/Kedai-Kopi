@extends('frontend.v_layouts.app')
@section('content')
<div class="offer container-fluid py-5 position-relative">
    <div class="container d-flex justify-content-center align-items-center pt-5" style="min-height: 100vh;">
        <div class="col-md-6 bg-dark p-5 rounded shadow">
            <h3 class="text-center text-white mb-4">Daftar Akun Baru</h3>
            @if (session()->has('Gagal'))
            <div class="alert alert-danger">{{ session('Gagal') }}</div>
            @endif
            <form action="{{ route('frontend.storeRegister') }}" method="post">
                @csrf
                <div class="form-group">
                    <label class="text-white">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="form-control bg-transparent text-white border-light"
                        placeholder="Nama lengkap" required
                        oninvalid="this.setCustomValidity('Nama lengkap tidak boleh kosong')"
                        oninput="this.setCustomValidity('')">
                </div>
                <div class="form-group">
                    <label class="text-white">Email</label>
                    <input type="email" name="email" id="email" class="form-control bg-transparent text-white border-light"
                        placeholder="Email aktif" required
                        oninvalid="this.setCustomValidity('Email tidak boleh kosong')"
                        oninput="this.setCustomValidity('')">
                </div>
                <div class="form-group">
                    <label class="text-white">Password</label>
                    <input type="password" name="password" id="password" class="form-control bg-transparent text-white border-light"
                        placeholder="Buat password" required
                        oninvalid="this.setCustomValidity('Password tidak boleh kosong')"
                        oninput="this.setCustomValidity('')">
                </div>
                <div class="form-group">
                    <label class="text-white">No. Telp</label>
                    <input type="number" name="telp" id="telp" class="form-control bg-transparent text-white border-light"
                        placeholder="Masukkan no telpon" required
                        oninvalid="this.setCustomValidity('Nomor telepon tidak boleh kosong')"
                        oninput="this.setCustomValidity('')">
                </div>
                <div class="form-group">
                    <label class="text-white">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control bg-transparent text-white border-light"
                        placeholder="Masukkan Alamat" required
                        oninvalid="this.setCustomValidity('Alamat tidak boleh kosong')"
                        oninput="this.setCustomValidity('')">
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-4">Daftar</button>
                <p class="text-white text-center mt-3">Sudah punya akun? <a href="{{ route('frontend.login') }}" class="text-warning">Login</a></p>
            </form>
        </div>
    </div>
</div>
@endsection