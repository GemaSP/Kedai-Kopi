@extends('backend.v_layouts.app')

@section('content')
<div class="container-fluid mb-4">
    <h1 class="h3 mb-3 text-gray-800">Detail Transaksi</h1>

    <!-- Info Transaksi -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white font-weight-bold">
            Informasi Transaksi
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">ID Transaksi</dt>
                <dd class="col-sm-9">{{ $transaksi->id_transaksi }}</dd>

                <dt class="col-sm-3">Status Pembayaran</dt>
                <dd class="col-sm-9">
                    @php
                    $badge = [
                    'Pending' => 'warning',
                    'Sukses' => 'success',
                    'Gagal' => 'danger'
                    ];
                    @endphp
                    <span class="badge badge-{{ $badge[$transaksi->status_pembayaran] ?? 'secondary' }}">
                        {{ ucfirst($transaksi->status_pembayaran) }}
                    </span>
                </dd>

                <dt class="col-sm-3">Jumlah Bayar</dt>
                <dd class="col-sm-9">Rp {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}</dd>

                <dt class="col-sm-3">Waktu Transaksi</dt>
                <dd class="col-sm-9">{{ $transaksi->created_at->format('d M Y, H:i') }}</dd>

                <dt class="col-sm-3">Invoice</dt>
                <dd class="col-sm-9">
                    @if ($transaksi->invoice_url)
                    <a href="{{ $transaksi->invoice_url }}" target="_blank" class="btn btn-sm btn-primary">Lihat Invoice</a>
                    @else
                    <span class="text-muted">Tidak tersedia</span>
                    @endif
                </dd>
            </dl>
        </div>
    </div>

    <!-- Info Pemesanan -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white font-weight-bold">
            Informasi Pemesanan
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">ID Pemesanan</dt>
                <dd class="col-sm-9">{{ $transaksi->pemesanan->id_pemesanan }}</dd>

                <dt class="col-sm-3">Pelanggan</dt>
                <dd class="col-sm-9">{{ $transaksi->pemesanan->user->nama ?? '-' }}</dd>

                <dt class="col-sm-3">Alamat</dt>
                <dd class="col-sm-9">{{ $transaksi->pemesanan->alamat }}</dd>

                <dt class="col-sm-3">Metode Pembayaran</dt>
                <dd class="col-sm-9">{{ $transaksi->pemesanan->metode_pembayaran }}</dd>

                <dt class="col-sm-3">Ongkir</dt>
                <dd class="col-sm-9">Rp {{ number_format($transaksi->pemesanan->ongkir, 0, ',', '.') }}</dd>

                <dt class="col-sm-3">Total Harga</dt>
                <dd class="col-sm-9">Rp {{ number_format($transaksi->pemesanan->total_harga, 0, ',', '.') }}</dd>
            </dl>
        </div>
    </div>

    <!-- Item Pemesanan -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white font-weight-bold">
            Daftar Produk
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi->pemesanan->item_pemesanan as $item)
                    <tr>
                        <td>{{ $item->produk->nama ?? '-' }}</td>
                        <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('backend.transaksi.index') }}" class="btn btn-secondary">Kembali ke Daftar Transaksi</a>
</div>
@endsection