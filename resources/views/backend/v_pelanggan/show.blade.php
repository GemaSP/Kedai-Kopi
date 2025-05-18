@extends('backend.v_layouts.app')

@section('content')
<div class="container-fluid mb-4">
    <h1 class="h3 mb-4 text-gray-800">Detail Pelanggan</h1>

    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <!-- Foto Profil -->
                <div class="col-md-4 text-center">
                    <img src="{{ asset('storage/image/foto-profil/' . ($pelanggan->user->foto ?? 'default.jpg')) }}"
                        alt="Foto Profil"
                        class="img-thumbnail mb-3"
                        width="250">
                    <h5 class="mt-2">{{ $pelanggan->nama }}</h5>
                    <p class="text-muted">{{ $pelanggan->user->email }}</p>
                </div>

                <!-- Detail Informasi -->
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID User</th>
                            <td>{{ $pelanggan->id_pelanggan }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $pelanggan->nama }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $pelanggan->user->email }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($pelanggan->user->status == 0)
                                <span class="badge badge-danger">Tidak Aktif</span>
                                @else
                                <span class="badge badge-success">Aktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>No. HP</th>
                            <td>{{ $pelanggan->telepon }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $pelanggan->alamat }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $pelanggan->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Diubah</th>
                            <td>{{ $pelanggan->updated_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    </table>

                    <a href="{{ route('backend.pelanggan.index') }}" class="btn btn-secondary mt-3">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pelanggan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection