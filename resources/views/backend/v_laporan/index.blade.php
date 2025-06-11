@extends('backend.v_layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Penjualan</h1>
    </div>

    <!-- Full Width Card -->
    <div class="card mt-4 w-100">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-file-alt"></i> Cetak Laporan Penjualan
        </div>
        <div class="card-body">
            <form id="formLaporan">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="tanggal_awal">Dari Tanggal</label>
                        <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" required oninvalid="this.setCustomValidity('Tanggal awal tidak boleh kosong')" oninput="setCustomValidity('')">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="tanggal_akhir">Sampai Tanggal</label>
                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" required oninvalid="this.setCustomValidity('Tanggal akhir tidak boleh kosong')" oninput="setCustomValidity('')">
                    </div>
                    <div class="form-group col-md-2 align-self-end">
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-print"></i> Cetak
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('formLaporan').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);

        fetch("{{ route('backend.laporan.cetak') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'error') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Tidak Ditemukan',
                        text: data.message
                    });
                } else if (data.status === 'success') {
                    // window.open(data.url, '_blank'); // buka PDF jika ada
                }
            })
            // .catch(error => {
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'Gagal',
            //         text: 'Terjadi kesalahan saat mencetak laporan.'
            //     });
            //     console.error(error);
            // });
    });
</script>

<!-- /.container-fluid -->
@endsection