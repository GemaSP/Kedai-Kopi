@extends('backend.v_layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tabel {{ $judul }}</h1>
    <p class="mb-2">Dibawah ini tabel yang berisikan data produk.</p>
    <a href="{{ route('backend.produk.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-2"><i
            class="fas fa-plus fa-sm text-white-50"></i> Tambah Produk</a>

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
                            <th>ID Produk</th>
                            <th>Nama</th>
                            <th>Menu</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Photo</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID Produk</th>
                            <th>Nama</th>
                            <th>Menu</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Photo</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($index as $row)
                        <tr>
                            <td>{{ $row->id_produk }}</td>
                            <td>{{ $row->nama }}</td>
                            <td>{{ $row->menu->nama_menu }}</td>
                            <td>{{ $row->deskripsi }}</td>
                            <td>{{ $row->harga }}</td>
                            <td><img src="{{ asset('storage/image/produk/'. $row->foto) }}" alt="" width="100px"></td>
                            <td>@if ($row->status == 1)
                                <span class="badge badge-success">Tersedia</span>
                                @else
                                <span class="badge badge-danger">Tidak Tersedia</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('backend.produk.destroy', $row->id_produk) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('backend.produk.edit', $row->id_produk) }}" class="btn btn-primary">Edit</a>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
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

</div>
<!-- End of Main Content -->

@endsection