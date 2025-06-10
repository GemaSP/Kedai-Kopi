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

        <!-- Form utama -->
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

                <div class="pr-3 mb-2 mb-md-0 item-total" style="width: 15%;" data-price="{{ $harga }}">
                    Rp {{ number_format($total, 0, ',', '.') }}
                </div>


                <div class="pr-3" style="width: 15%;">
                    <!-- Tombol hapus pakai JS -->
                    <button type="button" class="btn btn-sm btn-danger btn-delete-item" data-id="{{ $item->id }}">
                        <i class="fa fa-trash"></i>
                    </button>

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
                    <h5 class="text-white">Total: <span class="text-warning" id="totalHarga">Rp 0</span></h5>
                    <button type="submit" class="btn btn-primary mt-2">Checkout</button>
                </div>
            </div>
        </form>
        <form id="form-delete-{{ $item->id ?? 0 }}" method="POST" action="{{ route('frontend.keranjang.destroy', $item->id ?? 0) }}" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
<!-- Cart Page End -->

<!-- Script -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const checkAll = document.getElementById('checkAll');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const totalDisplay = document.querySelector('#totalHarga');

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.item-checkbox').forEach(cb => {
                const parent = cb.closest('.d-flex');
                const qtyInput = parent.querySelector('input[type="number"]');
                const price = parseInt(cb.dataset.price);
                const qty = parseInt(qtyInput.value);

                // Update total per item
                const itemTotal = parent.querySelector('.item-total');
                const totalPerItem = price * qty;
                itemTotal.textContent = `Rp ${totalPerItem.toLocaleString('id-ID')}`;

                if (cb.checked) {
                    total += totalPerItem;
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

        // AJAX update quantity
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('change', function() {
                const parent = this.closest('.d-flex');
                const itemId = parent.querySelector('.btn-delete-item').dataset.id;
                const newQty = this.value;

                fetch("{{ route('frontend.keranjang.updateQuantity') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id: itemId,
                            quantity: newQty
                        })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Gagal update quantity');
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            updateTotal(); // Update tampilan total juga
                        }
                    })
                    .catch(error => {
                        alert('Terjadi kesalahan saat menyimpan quantity.');
                        console.error(error);
                    });
            });
        });

        updateTotal(); // Inisialisasi saat pertama kali
    });

    // Tombol hapus item
    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll('.btn-delete-item');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                if (confirm('Yakin ingin menghapus item ini dari keranjang?')) {
                    document.getElementById(`form-delete-${id}`).submit();
                }
            });
        });
    });
</script>

@endsection