@extends('backend.v_layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data {{ $judul }}</h1>
    <p class="mb-4">Dibawah ini adalah tabel yang berisikan data pelanggan.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Data {{ $judul }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Pelanggan</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID Pelanggan</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($index as $row)
                        <tr>
                            <td>{{ $row->id_pelanggan }}</td>
                            <td>{{ $row->nama }}</td>
                            <td>{{ $row->user->email }}</td>
                            <td>{{ $row->telepon }}</td>
                            <td>{{ $row->alamat }}</td>
                            <td><img src="{{ asset('storage/image/foto-profil/' . ($row->user->foto ?? 'default.jpg')) }}" alt="" width="100" height="100"></td>
                            <td>
                                <!-- Tombol Detail -->
                                <a href="{{ route('backend.pelanggan.show', $row->id_pelanggan) }}" class="btn btn-warning btn-sm text-white mb-1">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

@endsection