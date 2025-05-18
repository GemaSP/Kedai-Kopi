<?php

namespace App\Http\Controllers;

use App\Models\ItemKeranjang;
use App\Models\ItemPemesanan;
use App\Models\Keranjang;
use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceApi;



class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data yang dipilih dari session
        $checkoutItems = session('checkout_items', []);

        // Jika tidak ada item yang dipilih, redirect ke halaman keranjang
        if (count($checkoutItems) === 0) {
            return redirect()->route('frontend.keranjang.index')->with('error', 'Tidak ada item yang dipilih untuk checkout.');
        }
        $keranjang = Keranjang::where('id_user', Auth::user()->id_user)->first();
        $keranjangCount = ItemKeranjang::where('id_keranjang', $keranjang->id_keranjang)->count();

        // Menampilkan halaman checkout dengan data item yang dipilih
        return view('frontend.v_checkout.index', [
            'judul' => 'Checkout',
            'user' => Auth::user(),
            'checkoutItems' => $checkoutItems,
            'keranjangCount' => $keranjangCount,
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
        //
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


    public function process(Request $request)
    {
        // Validasi input (dengan JSON response fallback)
        $validated = $request->validate([
            'alamat' => 'required|string',
            'wilayah' => 'required|string',
            'ongkir' => 'required|numeric',
            'metode' => 'required|in:cod,cashless',
        ]);

        $checkoutItems = session('checkout_items', []);
        if (empty($checkoutItems)) {
            return response()->json(['error' => 'Item kosong'], 400);
        }

        $alamat = $validated['alamat'];
        $wilayah = $validated['wilayah'];
        $ongkir = $validated['ongkir'];
        $metode = $validated['metode'];

        $total = array_sum(array_column($checkoutItems, 'total'));
        $totalBayar = $total + $ongkir;
        $user = Auth::user();

        $today = now()->format('dmY');
        $lastCount = DB::table('pemesanan')->whereDate('created_at', now()->toDateString())->count();
        $idPemesanan = 'PSN' . $today . str_pad($lastCount + 1, 3, '0', STR_PAD_LEFT);

        // Jika cashless, buat invoice di Xendit
        $invoiceUrl = null;
        if ($metode === 'cashless') {
            try {
                Configuration::setXenditKey('xnd_development_yyMAxQOjg2cyDcMhyLTq6OG1S6hAzoaEpAFDGZRFA42Krh0euNg91MoWVIxQzC');
                $apiInstance = new InvoiceApi();

                $create_invoice_request = new CreateInvoiceRequest([
                    'external_id' => $idPemesanan,
                    'payer_email' => $user->email,
                    'customer' => [
                        'given_names' => 'Ahmad',
                        'surname' => 'Gunawan',
                        'email' => 'ahmad_gunawan@example.com',
                        'mobile_number' => '+6287774441111',
                    ],
                    'amount' => $totalBayar,
                    'description' => 'Pembayaran untuk pesanan #' . $idPemesanan,
                    'success_redirect_url' => route('transaksi.finish', ['id_pemesanan' => $idPemesanan]),
                    'items' => array_merge(
                        array_map(function ($item) {
                            return [
                                'name' => $item['produk']->nama,
                                'price' => $item['produk']->harga,
                                'quantity' => $item['quantity'],
                                'total' => $item['total'],
                            ];
                        }, $checkoutItems),
                    ),
                    'fees' => [[
                        'type' => "Ongkos Kirim",
                        'value' => $ongkir,
                    ]]
                ]);

                $result = $apiInstance->createInvoice($create_invoice_request);
                $invoiceUrl = $result['invoice_url'];
            } catch (\Exception $e) {
                Log::error('Xendit invoice error: ' . $e->getMessage());
                return response()->json(['error' => 'Gagal membuat invoice Xendit.'], 500);
            }
        }

        // Simpan ke database
        DB::beginTransaction();
        try {
            DB::table('pemesanan')->insert([
                'id_pemesanan' => $idPemesanan,
                'id_user' => $user->id_user,
                'alamat' => $wilayah . ' - ' . $alamat,
                'metode_pembayaran' => 'Cashless(Transfer/E-Wallet)',
                'ongkir' => $ongkir,
                'total_harga' => $totalBayar,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($checkoutItems as $item) {
                DB::table('item_pemesanan')->insert([
                    'id_pemesanan' => $idPemesanan,
                    'id_produk' => $item['produk']->id_produk,
                    'quantity' => $item['quantity'],
                    'harga_satuan' => $item['produk']->harga,
                    'total' => $item['total'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Ambil keranjang milik user
            $keranjang = Keranjang::where('id_user', $user->id_user)->first();

            // Pastikan ada keranjang milik user, dan ada checkoutItems
            if ($keranjang && !empty($checkoutItems)) {
                // Ambil id_produk dari checkoutItems
                $produkIds = array_map(function ($item) {
                    return $item['produk']->id_produk;
                }, $checkoutItems);

                // Hapus item keranjang yang dipilih
                DB::table('item_keranjang')
                    ->where('id_keranjang', $keranjang->id_keranjang) // pastikan menggunakan id_keranjang yang valid
                    ->whereIn('id_produk', $produkIds)
                    ->delete();
            }



            $today = now()->format('dmY');
            $lastCount = DB::table('pemesanan')->whereDate('created_at', now()->toDateString())->count();
            $idTransaksi = 'TRX' . $today . str_pad($lastCount + 1, 3, '0', STR_PAD_LEFT);
            DB::table('transaksi')->insert([
                'id_transaksi' => $idTransaksi,
                'id_pemesanan' => $idPemesanan,
                'status_pembayaran' => 'Pending',
                'jumlah_bayar' => $totalBayar,
                'invoice_url' => $invoiceUrl,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            // Kosongkan session
            session()->forget('checkout_items');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('DB error saat simpan pesanan: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menyimpan pesanan.'], 500);
        }

        return response()->json(['invoice_url' => $invoiceUrl]);
    }


    public function codCheckout(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string',
            'wilayah' => 'required|string',
            'ongkir' => 'required|integer',
        ]);

        $user = Auth::user();
        $checkoutItems = session('checkout_items', []);


        if (empty($checkoutItems)) {
            return redirect()->back()->with('error', 'Tidak ada item untuk dipesan.');
        }

        DB::beginTransaction();

        try {
            // Generate ID pemesanan: PSNddmmyyyy###
            $tanggal = Carbon::now()->format('dmY');
            $lastId = DB::table('pemesanan')
                ->whereDate('created_at', Carbon::today())
                ->orderBy('id_pemesanan', 'desc')
                ->value('id_pemesanan');

            $nextNumber = 1;
            if ($lastId && Str::startsWith($lastId, 'PSN' . $tanggal)) {
                $lastNumber = (int)substr($lastId, -3);
                $nextNumber = $lastNumber + 1;
            }
            $idPemesanan = 'PSN' . $tanggal . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Hitung total barang
            $totalBarang = array_sum(array_column($checkoutItems, 'total'));
            $totalAkhir = $totalBarang + $request->ongkir;

            // Insert ke pemesanan
            DB::table('pemesanan')->insert([
                'id_pemesanan' => $idPemesanan,
                'id_user' => $user->id_user,
                'alamat' => $request->wilayah . ' - ' . $request->alamat,
                'metode_pembayaran' => 'COD',
                'ongkir' => $request->ongkir,
                'total_harga' => $totalAkhir,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert item_pemesanan
            foreach ($checkoutItems as $item) {
                DB::table('item_pemesanan')->insert([
                    'id_pemesanan' => $idPemesanan,
                    'id_produk' => $item['produk']->id_produk,
                    'quantity' => $item['quantity'],
                    'harga_satuan' => $item['produk']->harga,
                    'total' => $item['total'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Ambil keranjang milik user
            $keranjang = Keranjang::where('id_user', $user->id_user)->first();

            // Pastikan ada keranjang milik user, dan ada checkoutItems
            if ($keranjang && !empty($checkoutItems)) {
                // Ambil id_produk dari checkoutItems
                $produkIds = array_map(function ($item) {
                    return $item['produk']->id_produk;
                }, $checkoutItems);

                // Hapus item keranjang yang dipilih
                DB::table('item_keranjang')
                    ->where('id_keranjang', $keranjang->id_keranjang) // pastikan menggunakan id_keranjang yang valid
                    ->whereIn('id_produk', $produkIds)
                    ->delete();
            }

            $today = now()->format('dmY');
            $lastCount = DB::table('pemesanan')->whereDate('created_at', now()->toDateString())->count();
            $idTransaksi = 'TRX' . $today . str_pad($lastCount + 1, 3, '0', STR_PAD_LEFT);
            DB::table('transaksi')->insert([
                'id_transaksi' => $idTransaksi,
                'id_pemesanan' => $idPemesanan,
                'status_pembayaran' => 'Pending',
                'jumlah_bayar' => $totalAkhir,
                'invoice_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            // Kosongkan session
            session()->forget('checkout_items');

            return response()->json([
                'success' => true,
                'message' => 'Pesanan COD berhasil dibuat.',
                'redirect' => route('frontend.pesanan.index')
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }
}
