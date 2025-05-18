@extends('frontend.v_layouts.app')

@section('content')
<!-- Cart Page Start -->
<div class="offer container-fluid py-5 position-relative">
    <div class="container py-5 mt-5">
        <h2 class="text-white mb-4">Keranjang Saya</h2>

        <!-- Header bar -->
        <div class="d-none d-md-flex text-uppercase text-white mb-1 font-weight-bold border-bottom border-primary pb-2">
            <div class="pr-3" style="width: 5%;"><input type="checkbox" id="checkAll"></div>
            <div class="pr-3" style="width: 35%;">Produk</div>
            <div class="pr-3" style="width: 15%;">Harga</div>
            <div class="pr-3" style="width: 15%;">Jumlah</div>
            <div class="pr-3" style="width: 15%;">Total</div>
            <div class="pr-3" style="width: 15%;">Aksi</div>
        </div>

        <!-- Items -->
        <form method="post" action="{{ route('frontend.keranjang.checkout') }}">
            @csrf
            @if ($keranjang)
            @forelse($keranjang->item_keranjang as $item)
            @php
            $produk = $item->produk;
            $harga = $produk->harga;
            $qty = $item->quantity;
            $total = $harga * $qty;
            @endphp
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center text-white py-3 border-bottom border-primary">
                <div class="pr-3 mb-2 mb-md-0" style="width: 5%;">
                    <input type="hidden" name="items[{{ $produk->id_produk }}][selected]" value="0">
                    <input type="checkbox" name="items[{{ $produk->id_produk }}][selected]" class="item-checkbox" data-price="{{ $harga }}" value="1">
                </div>

                <div class="pr-3 d-flex align-items-center" style="width: 35%;">
                    <img src="{{ asset('storage/image/produk/'. $produk->foto) }}" alt="produk" class="img-fluid rounded mr-3" style="width: 60px; height: 60px; object-fit: cover;">
                    <div>
                        <h6 class="mb-1 text-white">{{ $produk->nama }}</h6>
                        <small class="text-muted">Ukuran: {{ ucfirst($item->ukuran ?? 'Default') }}</small>
                    </div>
                </div>

                <div class="pr-3 mb-2 mb-md-0" style="width: 15%;">
                    Rp {{ number_format($harga, 0, ',', '.') }}
                </div>

                <div class="pr-3 mb-2 mb-md-0" style="width: 15%;">
                    <input type="number" name="items[{{ $produk->id_produk }}][quantity]" class="form-control text-center bg-transparent text-white border-light" value="{{ $qty }}" min="1" style="width: 80px;">
                </div>

                <div class="pr-3 mb-2 mb-md-0" style="width: 15%;">
                    Rp {{ number_format($total, 0, ',', '.') }}
                </div>

                <div class="pr-3" style="width: 15%;">
                    <!-- <form method="POST" action="{{ route('frontend.keranjang.destroy', $item->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    </form> -->
                </div>
            </div>
            @empty
            <p class="text-white">Keranjang kamu kosong.</p>
            @endforelse
            @else
            <p class="text-white">Keranjang kamu kosong.</p>
            @endif

            <!-- Total & Checkout -->
            <div class="d-flex justify-content-end mt-4">
                <div class="text-right text-white">
                    <h5>Total: <span class="text-warning" id="totalHarga">Rp 0</span></h5>
                    <button type="submit" class="btn btn-primary mt-2">Checkout</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Cart Page End -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const checkAll = document.getElementById('checkAll');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const totalDisplay = document.querySelector('#totalHarga');

        function updateTotal() {
            let total = 0;
            itemCheckboxes.forEach((cb, index) => {
                if (cb.checked) {
                    const parent = cb.closest('.d-flex');
                    const qtyInput = parent.querySelector('input[type="number"]');
                    const price = parseInt(cb.dataset.price);
                    const qty = parseInt(qtyInput.value);
                    total += price * qty;
                }
            });
            totalDisplay.textContent = `Rp ${total.toLocaleString('id-ID')}`;
        }

        checkAll.addEventListener('change', function() {
            itemCheckboxes.forEach(cb => cb.checked = checkAll.checked);
            updateTotal();
        });

        itemCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateTotal);
        });

        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('change', updateTotal);
        });

        updateTotal(); // initialize
    });
</script>

@endsection