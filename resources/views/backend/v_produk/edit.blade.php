@extends('backend.v_layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Edit Produk</h3>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('backend.produk.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama">Nama Produk</label>
            <input type="text" name="nama" class="form-control" required value="{{ old('nama', $produk->nama) }}">
        </div>

        <div class="form-group">
            <label for="id_menu">Kategori Menu</label>
            <select name="id_menu" class="form-control" required>
                <option value="">-- Pilih Menu --</option>
                @foreach ($menu as $m)
                <option value="{{ $m->id_menu }}" {{ old('id_menu', $produk->id_menu) == $m->id_menu ? 'selected' : '' }}>
                    {{ $m->nama_menu }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi', $produk->deskripsi) }}</textarea>
        </div>

        <div class="form-group">
            <label for="harga">Harga (Rp)</label>
            <input type="number" name="harga" class="form-control" required value="{{ old('harga', $produk->harga) }}">
        </div>

        <div class="form-group">
            <label for="foto">Foto Produk (biarkan kosong jika tidak diubah)</label>
            <input type="file" accept="image/*" name="foto" class="form-control-file">
            @if ($produk->foto)
            <p class="mt-2">Foto saat ini: <img src="{{ asset('storage/image/produk/' . $produk->foto) }}" width="100"></p>
            @endif
        </div>

        <div class="form-group">
            <label for="status">Status Produk</label>
            <select name="status" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="1" {{ old('status', $produk->status) == '1' ? 'selected' : '' }}>Tersedia</option>
                <option value="0" {{ old('status', $produk->status) == '0' ? 'selected' : '' }}>Tidak Tersedia</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Update Produk</button>
        <a href="{{ route('backend.produk.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>

@endsection