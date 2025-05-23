@extends('frontend.v_layouts.app')

@section('content')
<div class="offer container-fluid py-5 position-relative"></div>
<div class="container py-5">
    <h3 class="mb-4">Detail Pesanan</h3>

    <div class="card shadow border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <div>
                <strong>ID Pesanan:</strong> {{ $pesanan->id_pemesanan }}<br>
                <small>Tanggal: {{ $pesanan->created_at->format('d M Y, H:i') }}</small>
            </div>
            <span class="badge badge-{{ $pesanan->status_badge }}">
                {{ $pesanan->status_label }}
            </span>
        </div>

        <div class="card-body bg-light">
            <h5 class="mb-3">Daftar Produk</h5>
            @php $subtotal = 0; @endphp
            @foreach ($pesanan->item_pemesanan as $item)
                @php $subtotal += $item->total; @endphp
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/image/produk/' . $item->produk->foto) }}"
                            alt="{{ $item->produk->nama }}"
                            class="img-fluid rounded mr-3"
                            style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <h6 class="mb-1">{{ $item->produk->nama }}</h6>
                            <small>Qty: {{ $item->quantity }} | Harga: Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</small>
                        </div>
                    </div>
                    <strong>Rp {{ number_format($item->total, 0, ',', '.') }}</strong>
                </div>
            @endforeach

            <div class="mt-3 text-end">
                <strong>Subtotal Produk: Rp {{ number_format($subtotal, 0, ',', '.') }}</strong><br>
                <strong>Ongkir: Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</strong><br>
                <strong>Total Harga: Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong><br>
                <small><strong>Metode Pembayaran:</strong> {{ ucfirst($pesanan->metode_pembayaran) }}</small><br>
                <small><strong>Status:</strong> {{ $pesanan->status_label }}</small>
            </div>

            @if ($pesanan->metode_pembayaran == 'Cashless(Transfer/E-Wallet)' && $pesanan->status == 1 && $pesanan->transaksi)
            <div class="mt-4">
                <a href="{{ $pesanan->transaksi->invoice_url }}" target="_blank" class="btn btn-warning">
                    Bayar Sekarang
                </a>
            </div>
            @endif

            @if ($pesanan->status == 3)
            <div class="mt-4">
                <form action="{{ route('frontend.pesanan.konfirmasi', $pesanan->id_pemesanan) }}" method="POST" onsubmit="return confirm('Konfirmasi bahwa pesanan telah sampai?')">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        Konfirmasi Sampai
                    </button>
                </form>
            </div>
            @endif

            @if ($pesanan->status == 1 && $pesanan->metode_pembayaran == 'COD')
            <div class="mt-4">
                <form action="{{ route('frontend.pesanan.batal', $pesanan->id_pemesanan) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        Batalkan Pesanan
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('frontend.pesanan.index') }}" class="btn btn-secondary">
            ← Kembali ke Daftar Pesanan
        </a>
    </div>
</div>
@endsection
