@extends('frontend.v_layouts.app')

@section('content')
<div class="offer container-fluid py-5 position-relative">
    <div class="container py-5">
        <h3 class="mb-4 text-white">Pesanan Saya</h3>

        @forelse ($pesananList as $pesanan)
        <div class="card mb-4 border-light shadow">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <div>
                    <strong>ID Pesanan:</strong> {{ $pesanan->id_pemesanan }}<br>
                    <small class="text-muted">Tanggal: {{ $pesanan->created_at->format('d M Y, H:i') }}</small>
                </div>
                <span class="badge badge-{{ $pesanan->status_badge }}">
                    {{ $pesanan->status_label }}
                </span>
            </div>
            <div class="card-body bg-secondary text-white">
                @foreach ($pesanan->item_pemesanan as $item)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/image/produk/' . $item->produk->foto) }}"
                            alt="{{ $item->produk->nama }}"
                            class="img-fluid rounded mr-3"
                            style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <h6 class="mb-1 text-white">{{ $item->produk->nama }}</h6>
                            <small>Qty: {{ $item->quantity }} | Harga: Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</small>
                        </div>
                    </div>
                    <div>
                        <strong>Rp {{ number_format($item->total, 0, ',', '.') }}</strong>
                    </div>
                </div>
                @endforeach

                <div class="text-right mt-3">
                    <strong>Total Pesanan: Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong>
                </div>

                {{-- Tombol aksi --}}
                <div class="d-flex justify-content-between mt-4 gap-2">
                    <div class="text-left">
                        <small class="text-light">
                            <strong>Metode Pembayaran:</strong> {{ ucfirst($pesanan->metode_pembayaran) }}
                        </small>
                    </div>
                    <div class="d-flex gap-2">
                        {{-- Tombol Ubah Alamat --}}
                        {{-- Tombol Detail --}}
                        <a href="{{ route('frontend.pesanan.detail', $pesanan->id_pemesanan) }}" class="btn btn-light btn-sm">
                            Detail
                        </a>

                        {{-- Tombol Konfirmasi Sampai --}}
                        @if ($pesanan->status == 3)
                        <form action="{{ route('frontend.pesanan.konfirmasi', $pesanan->id_pemesanan) }}" method="POST" onsubmit="return confirm('Konfirmasi bahwa pesanan telah sampai?')">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                Konfirmasi Sampai
                            </button>
                        </form>
                        @endif

                        {{-- Tombol Batal --}}
                        @if ($pesanan->status == 1 && $pesanan->metode_pembayaran == 'COD')
                        <form action="{{ route('frontend.pesanan.batal', $pesanan->id_pemesanan) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                Batal
                            </button>
                        </form>
                        @endif

                        {{-- Tombol Batal --}}
                        @if ($pesanan->status == 1 && $pesanan->metode_pembayaran == 'Cashless(Transfer/E-Wallet)')
                        <a href="{{ $pesanan->transaksi->invoice_url }}" class="btn btn-danger btn-sm">
                            Bayar
                        </a>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="alert alert-info text-center text-dark">
            Belum ada pesanan.
        </div>
        @endforelse
    </div>
</div>
@endsection