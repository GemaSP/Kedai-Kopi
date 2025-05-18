@extends('backend.v_layouts.app')

@section('content')
<div class="container-fluid mb-4">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profil Pengguna</h1>
    </div>

    <form action="{{ route('backend.profil.update', Auth::user()->id_user) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row ">
            <!-- Profile Card -->
            <div class="col-xl-4 mb-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <img id="preview-foto" class="img-profile rounded-circle mb-3"
                            src="{{ asset('storage/image/foto-profil/'.Auth::user()->foto) }}"
                            alt="Profil" width="200" height="200">
                        <h5 class="card-title">{{ Auth::user()->nama }}</h5>
                        <p class="card-text text-muted">{{ Auth::user()->email }}</p>

                        <!-- Input file tersembunyi -->
                        <input type="file" id="foto" name="foto" accept="image/*" style="display: none;" onchange="document.getElementById('form-profile').submit();">
                        <a href="#" class="btn btn-primary btn-sm" onclick="document.getElementById('foto').click(); return false;">
                            <i class="fas fa-edit"></i> Edit Photo
                        </a>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="col-xl-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">Edit Informasi Akun</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ old('nama', Auth::user()->nama) }}" required>
                                </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email', Auth::user()->email) }}" required>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if (Auth::user()->status == 0)
                                    <span class="badge badge-danger">Tidak Aktif</span>
                                    @else
                                    <span class="badge badge-success">Aktif</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Peran</th>
                                <td>
                                    @if (Auth::user()->role == 1)
                                    <span class="badge badge-primary">Admin</span>
                                    @elseif (Auth::user()->role == 2)
                                    <span class="badge badge-warning">Customer</span>
                                    @else
                                    <span class="badge badge-secondary">SuperAdmin</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <div class="text-right mt-3">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Keamanan -->
                <div class="card shadow">
                    <div class="card-header py-3 bg-warning text-white">
                        <h6 class="m-0 font-weight-bold">Keamanan & Akses</h6>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('backend.login') }}" class="btn btn-sm btn-warning mb-2">
                            <i class="fas fa-key"></i> Ganti Password
                        </a>
                        <a href="#" onclick="return confirm('Yakin ingin menghapus akun ini?')"
                            class="btn btn-sm btn-danger mb-2">
                            <i class="fas fa-trash"></i> Hapus Akun
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    document.getElementById('foto').addEventListener('change', function(event) {
        const input = event.target;
        const preview = document.getElementById('preview-foto');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    });
</script>
@endsection