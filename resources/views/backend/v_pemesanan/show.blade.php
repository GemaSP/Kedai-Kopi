@extends('backend.v_layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Detail Pemesanan</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <strong>ID Pemesanan:</strong> {{ $pemesanan->id_pemesanan }}<br>
            <strong>Tanggal:</strong> {{ $pemesanan->created_at->format('d M Y, H:i') }}
        </div>
        <div class="card-body">
            <h5>Informasi Pelanggan</h5>
            <p>
                <strong>Nama:</strong> {{ $pemesanan->user->nama }}<br>
                <strong>Alamat:</strong> {{ $pemesanan->alamat }}<br>
                <strong>Metode Pembayaran:</strong> {{ $pemesanan->metode_pembayaran }}<br>
                <strong>Status:</strong>
                @php
                $badge = [
                1 => 'secondary',
                2 => 'warning',
                3 => 'info',
                4 => 'success',
                5 => 'danger'
                ];
                $statusLabel = [
                1 => $pemesanan->metode_pembayaran == 'COD' ? 'Menunggu Konfirmasi' : 'Menunggu Pembayaran', // Menunggu Konfirmasi untuk COD,
                2 => 'Diproses',
                3 => 'Dikirim',
                4 => 'Selesai',
                5 => 'Dibatalkan'
                ];
                @endphp
                <span class="badge badge-{{ $badge[$pemesanan->status] ?? 'dark' }}">
                    {{ $statusLabel[$pemesanan->status] ?? 'Tidak Diketahui' }}
                </span>
            </p>

            <h5>Daftar Item</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga Satuan</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemesanan->item_pemesanan as $item)
                    <tr>
                        <td>{{ $item->produk->nama ?? '-' }}</td>
                        <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    @php
                    $totalProduk = $pemesanan->item_pemesanan->sum('total');
                    @endphp

                    <tr>
                        <td colspan="3"><strong>Subtotal Produk</strong></td>
                        <td>Rp {{ number_format($totalProduk, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="3"><strong>Ongkos Kirim</strong></td>
                        <td>Rp {{ number_format($pemesanan->ongkir, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="3"><strong>Total Bayar</strong></td>
                        <td><strong>Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-3">
                <a href="{{ route('backend.pemesanan.index') }}" class="btn btn-secondary">Kembali</a>

                @if ($pemesanan->status == 1 && $pemesanan->metode_pembayaran == 'COD')
                <form action="{{ route('backend.pemesanan.konfirmasi', $pemesanan->id_pemesanan) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-primary">Konfirmasi Pesanan</button>
                </form>
                @elseif ($pemesanan->status == 2)
                <form action="{{ route('backend.pemesanan.kirim', $pemesanan->id_pemesanan) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-info">Kirim Pesanan</button>
                </form>
                @elseif ($pemesanan->status == 3)
                <form action="{{ route('backend.pemesanan.selesai', $pemesanan->id_pemesanan) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-success">Tandai Selesai</button>
                </form>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection