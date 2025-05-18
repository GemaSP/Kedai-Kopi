@extends('frontend.v_layouts.app')
@section('content')
<div class="offer container-fluid py-5 position-relative">
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-6 bg-dark p-5 rounded shadow">
            <h3 class="text-center text-white mb-4">Login ke Akun Anda</h3>
            @if (session()->has('Sukses'))
            <div class="alert-success">{{ session('Sukses') }}</div>
            @elseif (session()->has('Gagal'))
            <div class="alert-danger">{{ session('Gagal') }}</div>
            @endif
            <form action="{{ route('frontend.storeLogin') }}" method="post">
                @csrf
                <div class="form-group">
                    <label class="text-white">Email</label>
                    <input type="email" name="email" id="email" class="form-control bg-transparent text-white border-light" placeholder="Masukkan email">
                </div>
                <div class="form-group">
                    <label class="text-white">Password</label>
                    <input type="password" name="password" id="password" class="form-control bg-transparent text-white border-light" placeholder="Masukkan password">
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-4">Masuk</button>
                <p class="text-white text-center mt-3">Belum punya akun? <a href="{{ route('frontend.register') }}" class="text-warning">Daftar di sini</a></p>
            </form>
        </div>
    </div>
</div>
@endsection