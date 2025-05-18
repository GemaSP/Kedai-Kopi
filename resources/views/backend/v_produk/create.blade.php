@extends('backend.v_layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Tambah Produk</h3>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('backend.produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nama">Nama Produk</label>
            <input type="text" name="nama" class="form-control" required value="{{ old('nama') }}">
        </div>

        <div class="form-group">
            <label for="menu_id">Kategori Menu</label>
            <select name="menu_id" class="form-control" required>
                <option value="">-- Pilih Menu --</option>
                @foreach ($menu as $m)
                <option value="{{ $m->id_menu }}" {{ old('menu_id') == $m->id_menu ? 'selected' : '' }}>
                    {{ $m->nama_menu }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi') }}</textarea>
        </div>

        <div class="form-group">
            <label for="harga">Harga (Rp)</label>
            <input type="number" name="harga" class="form-control" required value="{{ old('harga') }}">
        </div>

        <div class="form-group">
            <label for="foto">Foto Produk</label>
            <input type="file" accept="image/*" name="foto" class="form-control-file" required>
        </div>

        <div class="form-group">
            <label for="status">Status Produk</label>
            <select name="status" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Tersedia</option>
                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Tidak Tersedia</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Simpan Produk</button>
        <a href="{{ route('backend.produk.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>

@endsection