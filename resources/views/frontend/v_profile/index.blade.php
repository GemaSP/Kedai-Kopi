@extends('frontend.v_layouts.app')

@section('content')
<div class="offer container-fluid py-5 position-relative">
    <div class="container py-5">
        <h3 class="mb-4">Profil Saya</h3>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            {{-- Profil --}}
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">Informasi Profil</div>
                    <div class="card-body">
                        <form action="{{ route('frontend.profil.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="text-center mb-3">
                                <img src="{{ asset('storage/image/foto-profil/' . ($user->foto ?? 'default.jpg')) }}"
                                    class="rounded-circle" width="100" height="100" style="object-fit: cover;">
                            </div>

                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" value="{{ old('nama', $pelanggan->nama) }}" required>
                            </div>

                            <div class="form-group">
                                <label>Telepon</label>
                                <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $pelanggan->telepon) }}" required>
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control" required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Foto Profil</label>
                                <input type="file" name="foto" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Ganti Password --}}
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">Ganti Password</div>
                    <div class="card-body">
                        <form action="{{ route('frontend.profil.gantiPassword') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Password Lama</label>
                                <input type="password" name="password_lama" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="password" name="password_baru" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Konfirmasi Password Baru</label>
                                <input type="password" name="password_baru_confirmation" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-warning">Ganti Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection