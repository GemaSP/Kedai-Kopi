@extends('frontend.v_layouts.app')

@section('content')
<!-- Checkout Page Start -->
<div class="offer container-fluid py-5 position-relative">
    <div class="container py-5 mt-5">
        <h2 class="text-white mb-4">Checkout</h2>

        @php $checkoutItems = session('checkout_items', []); @endphp

        <!-- Notifikasi SweetAlert jika ada -->
        @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                confirmButtonColor: '#3085d6'
            });
        </script>
        @endif

        <!-- Form Checkout -->
        <form id="checkout-form">
            @csrf

            <!-- Daftar Produk -->
            <div class="table-responsive mb-4">
                <table class="table table-borderless text-white">
                    <thead class="text-uppercase border-bottom border-primary">
                        <tr>
                            <th style="width: 40%;">Produk</th>
                            <th style="width: 15%;">Harga</th>
                            <th style="width: 15%;">Jumlah</th>
                            <th style="width: 15%;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($checkoutItems as $item)
                        <tr class="align-middle border-bottom border-secondary">
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/image/produk/' . $item['produk']->photo) }}" alt="produk"
                                        class="img-fluid rounded mr-3" style="width: 60px; height: 60px; object-fit: cover;">
                                    <div>
                                        <h6 class="mb-1 text-white">{{ $item['produk']->nama }}</h6>
                                        <small class="text-muted">Ukuran: {{ ucfirst($item['ukuran'] ?? 'Default') }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>Rp {{ number_format($item['produk']->harga, 0, ',', '.') }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Alamat dan Bayar -->
            <div class="row">
                <div class="col-md-6 mb-3 pb-3">
                    <label class="text-white" for="wilayah">Pilih Wilayah</label>
                    <select name="wilayah" id="wilayah" class="form-control bg-transparent text-white border-light" required>
                        <option class="bg-primary" value="">-- Pilih Wilayah --</option>
                        <optgroup class="bg-primary" label="Kota Bogor">
                            <option value="Bogor Tengah">Bogor Tengah</option>
                            <option value="Bogor Utara">Bogor Utara</option>
                            <option value="Bogor Timur">Bogor Timur</option>
                            <option value="Bogor Selatan">Bogor Selatan</option>
                            <option value="Bogor Barat">Bogor Barat</option>
                            <option value="Tanah Sareal">Tanah Sareal</option>
                        </optgroup>
                        <optgroup class="bg-primary" label="Kabupaten Bogor">
                            <option value="Dramaga">Dramaga</option>
                            <option value="Ciomas">Ciomas</option>
                            <option value="Cibinong">Cibinong</option>
                            <option value="Sukaraja">Sukaraja</option>
                            <option value="Kemang">Kemang</option>
                            <option value="Bojonggede">Bojonggede</option>
                        </optgroup>
                    </select>
                </div>
                <div class="col-md-6 mb-3 pb-3">
                    <label class="text-white" for="alamat">Alamat Pengiriman</label>
                    <textarea name="alamat" id="alamat" class="form-control bg-transparent text-white border-light" rows="4" required></textarea>
                    <div class="mb-4">
                        <label class="text-white" for="metode_pembayaran">Metode Pembayaran</label>
                        <select id="metode_pembayaran" name="metode_pembayaran" class="form-control bg-transparent text-white border-light" required>
                            <option class="bg-primary" value="">-- Pilih Metode Pembayaran --</option>
                            <option class="bg-primary" value="cod">COD (Bayar di Tempat)</option>
                            <option class="bg-primary" value="cashless">Online (Transfer / eWallet)</option>
                        </select>
                    </div>
                </div>
            </div>
            <input type="hidden" id="total-barang" value="{{ array_sum(array_column($checkoutItems, 'total')) ?? 0 }}">
            <!-- Ongkir dan Total Bayar -->
            <div class="text-right text-white">
                <h6 class="text-white">Total Produk: <span>Rp {{ number_format(array_sum(array_column($checkoutItems, 'total')), 0, ',', '.') }}</span></h6>
                <h6 class="text-white">Ongkos Kirim: <span id="ongkir">Rp 0</span></h6>
                <h5 class="text-white">Total:
                    <span class="text-warning" id="total-bayar">
                        Rp {{ number_format(array_sum(array_column($checkoutItems, 'total')), 0, ',', '.') }}
                    </span>
                </h5>
                <button type="button" id="pay-button" class="btn btn-primary mt-2">Bayar Sekarang</button>
            </div>
        </form>
        <!-- Tombol untuk membuka modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#paymentModal">
            Buka Modal Pembayaran
        </button>

        <!-- Modal -->
        <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Pembayaran Anda</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <h4>Total Pembayaran</h4>
                            <h3><strong>Rp 1.000.000</strong></h3>

                            <p>Metode Pembayaran:</p>
                            <select class="custom-select mb-3" id="paymentMethod">
                                <option value="COD">Cash On Delivery (COD)</option>
                                <option value="card">Kartu Kredit/Debit</option>
                                <option value="gopay">GoPay</option>
                                <option value="ovo">OVO</option>
                            </select>

                            <div id="paymentInfo" class="mt-4">
                                <p><strong>Pastikan informasi pembayaran sudah benar sebelum melanjutkan.</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-warning btn-lg">Lanjutkan Pembayaran</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap CSS -->

        <!-- Bootstrap JS and dependencies -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


        @php $totalBarang = array_sum(array_column($checkoutItems, 'total')) ?? 0; @endphp
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Midtrans Snap -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

        <!-- JavaScript untuk Menghitung Ongkir -->
        <script>
            const ongkirMap = {
                'Bogor Tengah': 5000,
                'Bogor Utara': 7000,
                'Bogor Timur': 7000,
                'Bogor Selatan': 8000,
                'Bogor Barat': 8000,
                'Tanah Sareal': 8000,
                'Dramaga': 10000,
                'Ciomas': 10000,
                'Cibinong': 12000,
                'Sukaraja': 12000,
                'Kemang': 12000,
                'Bojonggede': 12000
            };

            const wilayahSelect = document.getElementById('wilayah');
            const ongkirSpan = document.getElementById('ongkir');
            const totalBayarSpan = document.getElementById('total-bayar');
            const totalBarang = parseInt(document.getElementById('total-barang').value) || 0;
            // PHP to JS

            wilayahSelect.addEventListener('change', () => {
                const wilayah = wilayahSelect.value;
                const ongkir = ongkirMap[wilayah] || 0;
                const total = totalBarang + ongkir;

                ongkirSpan.innerText = 'Rp ' + ongkir.toLocaleString('id-ID');
                totalBayarSpan.innerText = 'Rp ' + total.toLocaleString('id-ID');
            });

            document.getElementById('pay-button').addEventListener('click', function() {
                const alamat = document.getElementById('alamat').value;
                const wilayah = document.getElementById('wilayah').value;
                const ongkir = ongkirMap[wilayah] || 0;
                const metode = document.getElementById('metode_pembayaran').value;

                if (!alamat || !wilayah || !metode) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Form belum lengkap!',
                        text: 'Silakan isi semua data yang diperlukan.'
                    });
                    return;
                }

                const payload = {
                    alamat,
                    wilayah,
                    ongkir,
                    metode
                };

                if (metode === 'cod') {
                    // Proses pembayaran COD
                    fetch("{{ route('frontend.checkout.cod') }}", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify(payload)
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                window.location.href = data.redirect;
                            } else {
                                Swal.fire('Error', data.message || 'Gagal memproses pesanan COD.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error("COD error:", error);
                            Swal.fire('Error', 'Terjadi kesalahan saat menghubungi server.', 'error');
                        });
                } else if (metode === 'cashless') {
                    // Proses pembayaran dengan Xendit
                    fetch("{{ route('frontend.checkout.process') }}", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json",
                                "Accept": "application/json"
                            },
                            body: JSON.stringify({
                                alamat: alamat,
                                wilayah: wilayah,
                                ongkir: ongkir,
                                metode: 'cashless'
                            })
                        })
                        .then(res => res.json())
                        .then(res => {
                            if (res.invoice_url) {
                                window.location.href = res.invoice_url;
                            } else if (res.error) {
                                Swal.fire('Gagal', res.error, 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
                        });
                }
            });
        </script>
    </div>
</div>
<!-- Checkout Page End -->
@endsection