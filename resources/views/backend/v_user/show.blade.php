@extends('backend.v_layouts.app')

@section('content')
<div class="container-fluid mb-4">
    <h1 class="h3 mb-4 text-gray-800">Detail User</h1>

    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <!-- Foto Profil -->
                <div class="col-md-4 text-center">
                    <img src="{{ asset('storage/image/foto-profil/' . ($user->foto ?? 'default.jpg')) }}"
                        alt="Foto Profil"
                        class="img-thumbnail mb-3"
                        width="250">
                    <h5 class="mt-2">{{ $user->nama }}</h5>
                    <p class="text-muted">{{ $user->email }}</p>
                </div>

                <!-- Detail Informasi -->
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID User</th>
                            <td>{{ $user->id_user }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $user->nama }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($user->status == 0)
                                <span class="badge badge-danger">Tidak Aktif</span>
                                @else
                                <span class="badge badge-success">Aktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>
                                @if($user->role == 1)
                                <span class="badge badge-primary">Admin</span>
                                @elseif($user->role == 2)
                                <span class="badge badge-warning">Customer</span>
                                @else
                                <span class="badge badge-secondary">SuperAdmin</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $user->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Diubah</th>
                            <td>{{ $user->updated_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    </table>

                    <a href="{{ route('backend.user.index') }}" class="btn btn-secondary mt-3">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pengguna
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection