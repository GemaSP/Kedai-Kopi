<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            margin-bottom: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        ul {
            padding-left: 20px;
        }

        .section {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <h2>Laporan Penjualan</h2>
    <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($tanggal_awal)->format('d M Y') }} - {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d M Y') }}</p>

    <div class="section">
        <h4>Ringkasan</h4>
        <ul>
            <li>Total Transaksi: {{ $totalTransaksi }}</li>
            <li>Total Pendapatan: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</li>
            <li>Cashless: {{ $cashless }} transaksi</li>
            <li>COD: {{ $cod }} transaksi</li>
        </ul>
    </div>

    <div class="section">
        <h4>Rekap Harian</h4>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jumlah Transaksi</th>
                    <th>Total Penjualan (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rekapHarian as $rekap)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($rekap->tanggal)->format('d M Y') }}</td>
                    <td>{{ $rekap->jumlah_transaksi }}</td>
                    <td>{{ number_format($rekap->total_penjualan, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h4>Produk Terlaris (Top 5)</h4>
        <table>
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Jumlah Terjual</th>
                    <th>Total Penjualan (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produkTerlaris as $produk)
                <tr>
                    <td>{{ $produk->nama }}</td>
                    <td>{{ $produk->terjual }}</td>
                    <td>{{ number_format($produk->total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h4>Detail Transaksi</h4>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Total (Rp)</th>
                    <th>Metode Pembayaran</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksiDetail as $transaksi)
                <tr>
                    <td>{{ $transaksi->tanggal }}</td>
                    <td>{{ $transaksi->pelanggan }}</td>
                    <td>{{ $transaksi->produk }}</td>
                    <td>{{ $transaksi->qty }}</td>
                    <td>{{ number_format($transaksi->total, 0, ',', '.') }}</td>
                    <td>{{ $transaksi->metode }}</td>
                    <td>{{ $transaksi->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>