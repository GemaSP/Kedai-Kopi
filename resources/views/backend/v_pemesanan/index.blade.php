@extends('backend.v_layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Data Pemesanan</h1>
    <p class="mb-4">Berikut adalah daftar seluruh pemesanan yang dilakukan pelanggan.</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Pemesanan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Metode Bayar</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemesananList as $pesanan)
                        <tr>
                            <td>{{ $pesanan->id_pemesanan }}</td>
                            <td>{{ $pesanan->user->nama ?? '-' }}</td>
                            <td>{{ $pesanan->created_at->format('d M Y, H:i') }}</td>
                            <td>{{ $pesanan->metode_pembayaran }}</td>
                            <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $badge = [
                                        1 => 'secondary',
                                        2 => 'warning',
                                        3 => 'info',
                                        4 => 'success',
                                        5 => 'danger'
                                    ];
                                    $statusLabel = [
                                        1 => $pesanan->metode_pembayaran == 'COD' ? 'Menunggu Konfirmasi' : 'Menunggu Pembayaran', // Menunggu Konfirmasi untuk COD,
                                        2 => 'Diproses',
                                        3 => 'Dikirim',
                                        4 => 'Selesai',
                                        5 => 'Dibatalkan'
                                    ];
                                @endphp
                                <span class="badge badge-{{ $badge[$pesanan->status] ?? 'dark' }}">
                                    {{ $statusLabel[$pesanan->status] ?? 'Tidak Diketahui' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('backend.pemesanan.show', $pesanan->id_pemesanan) }}" class="btn btn-info btn-sm">Detail</a>
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
