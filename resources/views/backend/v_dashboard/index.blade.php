@extends('backend.v_layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid mb-4">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pemesanan (Hari ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahPemesanan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pendapatan (Hari ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pendapatan (Bulan ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Jumlah Pelanggan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahPelanggan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Penjualan -->
    <div class="row d-flex align-items-stretch">
        <div class="col-md-6 d-flex">
            <div class="card w-100 mb-4">
                <div class="card-header bg-primary text-white">Grafik Pendapatan (30 Hari)</div>
                <div class="card-body">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 d-flex">
            <div class="card w-100 mb-4">
                <div class="card-header bg-primary text-white">Pelanggan dengan pembelian terbanyak (Top 10)</div>
                <div class="card-body">
                    <canvas id="buyerChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row d-flex align-items-stretch">
        <div class="col-md-6 d-flex">
            <div class="card w-100 mb-4">
                <div class="card-header bg-primary text-white">Top 10 Produk</div>
                <div class="card-body">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 d-flex">
            <div class="card w-100 mb-4">
                <div class="card-header bg-primary text-white">Kalender</div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tabel Pesanan Belum Diproses -->
    @if (Auth::user()->role == 0)

    @else
    <div class="card mt-4">
        <div class="card-header bg-danger text-white">
            <i class="fas fa-bell"></i> Pesanan Belum Diproses
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Metode Bayar</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>PSN08052025010</td>
                        <td>Agus Susanto</td>
                        <td>08 May 2025, 15:16</td>
                        <td>COD</td>
                        <td>Rp 138.000</td>
                        <td><span class="badge badge-danger">Belum Diproses</span></td>
                        <td><button class="btn btn-sm btn-success">Proses</button></td>
                    </tr>
                    <tr>
                        <td>PSN08052025011</td>
                        <td>Yuliana Sari</td>
                        <td>08 May 2025, 15:18</td>
                        <td>Cashless</td>
                        <td>Rp 98.000</td>
                        <td><span class="badge badge-danger">Belum Diproses</span></td>
                        <td><button class="btn btn-sm btn-success">Proses</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
<!-- /.container-fluid -->

<!-- Chart.js -->
<script src="{{ asset('backend/vendor/chart.js/chart.umd.js') }}"></script>

<script>
    // ================= Line Chart: Pendapatan Harian =================
    const ctxLine = document.getElementById('lineChart').getContext('2d');
    const labelsLine = <?php echo json_encode($pendapatanHarian->pluck('tanggal')) ?>;
    const dataLine = <?php echo json_encode($pendapatanHarian->pluck('total')) ?>;

    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: labelsLine,
            datasets: [{
                label: 'Pendapatan Harian',
                data: dataLine,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    // ================= Bar Chart: Produk Terlaris =================
    const ctxBar = document.getElementById('barChart').getContext('2d');
    const produkLabels = <?php echo json_encode($topProduk->pluck('nama')) ?>;
    const produkData = <?php echo json_encode($topProduk->pluck('total_terjual')) ?>;

    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: produkLabels,
            datasets: [{
                label: 'Jumlah Terjual',
                data: produkData,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // ================= Bar Chart: Top Pembeli =================
    const ctxBuyer = document.getElementById('buyerChart').getContext('2d');
    const labelsBuyer = <?php echo json_encode($topPembeli->pluck('nama')) ?>;
    const dataBuyer = <?php echo json_encode($topPembeli->pluck('total_beli')) ?>;

    new Chart(ctxBuyer, {
        type: 'bar',
        data: {
            labels: labelsBuyer,
            datasets: [{
                label: 'Jumlah Pembelian',
                data: dataBuyer,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // ================= FullCalendar =================
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 250,
            contentHeight: 250
        });
        calendar.render();
    });
</script>

<!-- FullCalendar -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>

</div>
<!-- End of Main Content -->

@endsection