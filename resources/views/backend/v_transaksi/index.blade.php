@extends('backend.v_layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Data Transaksi</h1>
    <p class="mb-4">Berikut adalah daftar transaksi pembayaran yang dilakukan pelanggan.</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>ID Pemesanan</th>
                            <th>Pelanggan</th>
                            <th>Status Pembayaran</th>
                            <th>Jumlah Bayar</th>
                            <th>Waktu Transaksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksiList as $trx)
                        <tr>
                            <td>{{ $trx->id_transaksi }}</td>
                            <td>{{ $trx->id_pemesanan }}</td>
                            <td>{{ $trx->pemesanan->user->nama ?? '-' }}</td>
                            <td>
                                @php
                                $badge = [
                                'Pending' => 'warning',
                                'Sukses' => 'success',
                                'Gagal' => 'danger'
                                ];
                                @endphp
                                <span class="badge badge-{{ $badge[$trx->status_pembayaran] ?? 'secondary' }}">
                                    {{ ucfirst($trx->status_pembayaran) }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($trx->jumlah_bayar, 0, ',', '.') }}</td>
                            <td>{{ $trx->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                @php
                                $createdAt = \Carbon\Carbon::parse($trx->created_at);
                                $expiredAt = $createdAt->addHours(24);
                                @endphp
                                @if ($trx->status_pembayaran === 'pending' && now()->greaterThanOrEqualTo($expiredAt))
                                <form action="{{ route('backend.transaksi.update', $trx->id_transaksi) }}" method="POST" onsubmit="return confirm('Yakin batalkan transaksi ini?')">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-danger btn-sm">Batalkan</button>
                                </form>
                                @else
                                <span class="text-muted"></span>
                                @endif
                                <a href="{{ route('backend.pemesanan.show', $trx->id_pemesanan) }}" class="btn btn-info btn-sm">Detail</a>
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