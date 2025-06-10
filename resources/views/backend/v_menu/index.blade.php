@extends('backend.v_layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tabel {{ $judul }}</h1>
    <p class="mb-2">Dibawah ini adalah tabel yang berisi daftar menu.</p>
    <!-- Tombol Trigger Modal Tambah -->
    <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-2" data-toggle="modal" data-target="#modalTambah">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Menu
    </button>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('backend.menu.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_menu">Nama Menu</label>
                            <input type="text" class="form-control" id="nama_menu" name="nama_menu" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            </form>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Menu</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID Menu</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($index as $row)
                        <tr>
                            <td>{{ $row->id_menu }}</td>
                            <td>{{ $row->nama_menu }}</td>
                            <td>
                                <form id="delete-form-{{ $row->id_menu }}" action="{{ route('backend.menu.destroy', $row->id_menu) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-primary editBtn"
                                        data-id="{{ $row->id_menu }}"
                                        data-nama="{{ $row->nama_menu }}"
                                        data-url="{{ route('backend.menu.update', $row->id_menu) }}"
                                        data-toggle="modal"
                                        data-target="#editModal">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-danger deleteBtn" data-nama="{{ $row->nama_menu }}">Hapus</button>
                                </form>
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
<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Menu</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editId" name="id_menu">
                    <div class="form-group">
                        <label for="editNama">Nama Menu</label>
                        <input type="text" class="form-control" id="editNama" name="nama_menu" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.editBtn');
        const editNamaInput = document.getElementById('editNama');
        const editForm = document.getElementById('editForm');

        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const nama = this.getAttribute('data-nama');
                const url = this.getAttribute('data-url');

                editNamaInput.value = nama;
                editForm.setAttribute('action', url);
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.deleteBtn');

        deleteButtons.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const form = btn.closest('form');
                const nama = btn.getAttribute('data-nama') || 'menu ini';

                Swal.fire({
                    title: 'Yakin?',
                    html: 'Anda akan menghapus <b>' + nama + '</b>!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

</div>
<!-- End of Main Content -->

@endsection