<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksiList = Transaksi::with(['pemesanan.user'])->latest()->get();

        return view('backend.v_transaksi.index', [
            'judul' => 'Transaksi',
            'user' => Auth::user(),
            'transaksiList' => $transaksiList,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        if ($hashed == $request->signature_key) {
            $idPemesanan = $request->input('order_id'); // dari Midtrans callback
            $statusPembayaran = $request->input('transaction_status'); // misalnya: 'settlement', 'pending', dll
            $jumlahBayar = $request->input('gross_amount'); // total dari midtrans
            $statusMap = [
                'settlement' => 'Sukses',
                'capture' => 'Sukses',
                'pending' => 'Pending',
                'deny' => 'Gagal',
                'expire' => 'Gagal',
                'cancel' => 'Gagal',
            ];

            $status = $statusMap[$statusPembayaran] ?? 'Pending';

            // Simpan transaksi
            try {
                DB::table('transaksi')->where('id_transaksi',)->update([
                    'status_pembayaran' => $status,
                    'updated_at' => now(),
                ]);
            } catch (\Exception $e) {
                return redirect('/checkout/failed')->with('error', 'Gagal menyimpan transaksi.');
            }
        }

        // Redirect atau tampilkan halaman sukses
        return redirect()->route('frontend.pesanan.index')->with('success', 'Transaksi berhasil diproses.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function finish(Request $request,)
    {
        $invoice_id = $request->get('id_pemesanan');
        $transactionId = $request->get('transaction_id');  // ID Transaksi untuk identifikasi lebih lanjut jika diperlukan

        // API Key Xendit
        $xenditApiKey = config('services.xendit.api_key');

        // URL untuk cek status transaksi Xendit berdasarkan invoice_id
        $url = 'https://api.xendit.co/transactions/';

        try {
            // Mengirim permintaan GET ke Xendit dengan basic auth untuk mendapatkan status transaksi
            $response = Http::withBasicAuth($xenditApiKey, '')->get($url);
            // Debugging: tampilkan respons dari Xendit
            // Mengecek apakah permintaan berhasil
            if ($response->successful()) {
                $data = $response->json();  // Mendapatkan data JSON dari respons

                // Mengecek jika data transaksi tersedia
                if (isset($data['data']) && !empty($data['data'])) {
                    // Filter transaksi berdasarkan invoice_id
                    $transaction = collect($data['data'])->firstWhere('reference_id', $invoice_id);
                    // Debugging: tampilkan transaksi yang ditemukan
                 
                    // Pastikan ada transaksi yang ditemukan
                    if ($transaction) {
                        // Mendapatkan status pembayaran dari Xendit
                        $status = $transaction['status'];
                        // Status transaksi

                        // Mapping status dari Xendit ke status internal
                        $statusMap = [
                            'SUCCESS' => 'Sukses',
                            'UNPAID' => 'Gagal',
                            'EXPIRED' => 'Gagal',
                            'CANCELLED' => 'Gagal',
                            'PENDING' => 'Pending',
                        ];

                        $paymentStatus = $statusMap[$status] ?? 'Pending';  // Default ke pending jika status tidak ditemukan

                        DB::table('pemesanan')->where('id_pemesanan', $invoice_id)->update([
                            'status' => 2,
                            'updated_at' => now(),
                        ]);

                        DB::table('transaksi')->where('id_pemesanan', $invoice_id)->update([
                            'status_pembayaran' => $paymentStatus,
                            'updated_at' => now(),
                        ]);

                        return redirect()->route('frontend.pesanan.index')->with('success', 'Transaksi berhasil diproses.');
                    } else {
                        return redirect()->route('frontend.pesanan.index')->with('error', 'Transaksi tidak ditemukan.');
                    }
                } else {
                    return redirect()->route('frontend.pesanan.index')->with('error', 'Data transaksi tidak ditemukan.');
                }
            } else {
                // Jika respons gagal, log error dan tampilkan pesan error
                Log::error('Gagal mendapatkan status transaksi Xendit: ' . $response->body());
                return redirect()->route('frontend.pesanan.index')->with('error', 'Gagal memproses transaksi.');
            }
        } catch (\Exception $e) {
            // Tangani error jika terjadi kesalahan pada request
            Log::error('Xendit invoice status error: ' . $e->getMessage());
            return redirect()->route('frontend.pesanan.index')->with('error', 'Gagal memproses transaksi.');
        }
    }
}
