@extends('backend.v_layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data {{ $judul }}</h1>
    <p class="mb-4">Dibawah ini adalah tabel yang berisikan data user.</p>

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
                            <th>ID User</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID User</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($index as $row)
                        <tr>
                            <td>{{ $row->id_user }}</td>
                            <td>{{ $row->nama }}</td>
                            <td>{{ $row->email }}</td>
                            <td>@if($row->status == 0)
                                <span class="badge badge-danger">Tidak Aktif</span>
                                @else
                                <span class="badge badge-success">Aktif</span>
                                @endif
                            </td>
                            <td>
                                @if ($row->role == 1)
                                <span class="badge badge-danger">Admin</span>
                                @elseif ($row->role == 2)
                                <span class="badge badge-success">Pelanggan</span>
                                @else
                                <span class="badge badge-info">Pemilik</span>
                                @endif
                            </td>
                            <td><img src="{{ asset('storage/image/foto-profil/' . ($row->foto ?? 'default.jpg')) }}" alt="" width="100" height="100"></td>
                            <td>
                                <!-- Tombol Detail -->
                                <a href="{{ route('backend.user.show', $row->id_user) }}" class="btn btn-warning btn-sm text-white mb-1">
                                    Detail
                                </a>

                                <!-- Tombol Status Aktif / Nonaktif -->
                                @if ($row->status == 1)
                                <form id="toggle-form-{{ $row->id_user }}" action="{{ route('backend.user.toggleStatus', $row->id_user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="konfirmasiToggle('{{ $row->id_user }}', '{{ $row->nama }}' , 'nonaktifkan')">
                                        Nonaktifkan
                                    </button>
                                </form>
                                @else
                                <form id="toggle-form-{{ $row->id_user }}" action="{{ route('backend.user.toggleStatus', $row->id_user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button" class="btn btn-success btn-sm" onclick="konfirmasiToggle('{{ $row->id_user }}', '{{ $row->nama }}' , 'aktifkan')">
                                        Aktifkan
                                    </button>
                                </form>
                                @endif
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function konfirmasiToggle(id, nama, aksi) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            html: 'Anda akan ' + aksi + ' user <b>' + nama + '</b> ini!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: aksi === 'aktifkan' ? '#28a745' : '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, ' + aksi + '!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('toggle-form-' + id).submit();
            }
        });
    }
</script>

@endsection