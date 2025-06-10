<?php

namespace App\Http\Controllers;

use App\Models\ItemKeranjang;
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $userId = Auth::user()->id_user;
        $user = User::where('id_user', $userId)->first();

        if (Auth::check()) {
            $idUser = Auth::user()->id_user;
            $keranjang = Keranjang::where('id_user', $idUser)->first();

            if ($keranjang) {
                $keranjangCount = ItemKeranjang::where('id_keranjang', $keranjang->id_keranjang)->count();
            } else {
                $keranjangCount = 0; // Atau sesuaikan sesuai logika kamu
            }
        }


        return view('frontend.v_cart.index', [
            'judul' => 'Keranjang',
            'user' => $user,
            'keranjang' => $keranjang,
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
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
        ]);

        $user = Auth::user();

        // Ambil 3 digit kode dari id_user (USR001 -> 001)
        $userCode = substr($user->id_user, -3);

        // Cek apakah user sudah punya keranjang yang aktif (misal keranjang yg belum checkout)
        $cart = Keranjang::where('id_user', $user->id_user)->first();

        if (!$cart) {
            // Ambil nomor urut terakhir dari keranjang user
            $lastCart = Keranjang::where('id_user', $user->id_user)
                ->orderBy('id_keranjang', 'desc')
                ->first();

            $nextNumber = 1;

            if ($lastCart) {
                // Ambil 3 digit terakhir dari id_keranjang lalu tambah 1
                $lastNumber = (int)substr($lastCart->id_keranjang, -3);
                $nextNumber = $lastNumber + 1;
            }

            // Format ID keranjang: KRJ + userCode + 3 digit nomor urut
            $idKeranjang = 'KRJ' . $userCode . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Buat keranjang baru
            $cart = Keranjang::create([
                'id_keranjang' => $idKeranjang,
                'id_user' => $user->id_user,
            ]);
        }

        // Tambah atau update item keranjang
        $item = $cart->item_keranjang()->where('id_produk', $request->id_produk)->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            $cart->item_keranjang()->create([
                'id_produk' => $request->id_produk,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('keranjangSuccess', 'Produk berhasil ditambahkan ke keranjang.');
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
    public function destroy($id)
    {
        // Temukan item keranjang berdasarkan ID
        $item = ItemKeranjang::findOrFail($id);

        // Hapus item keranjang
        $item->delete();

        // Redirect kembali ke halaman keranjang dengan pesan sukses
        return redirect()->route('frontend.keranjang.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        // Simpan data produk yang dipilih dan kuantitas di session
        $selectedItems = [];

        foreach ($request->input('items') as $itemId => $data) {
            if ($data['selected'] == '1') {
                $produk = Produk::find($itemId);
                $selectedItems[] = [
                    'produk' => $produk,
                    'quantity' => $data['quantity'],
                    'total' => $produk->harga * $data['quantity'],
                ];
            }
        }

        // Simpan ke session
        session(['checkout_items' => $selectedItems]);

        // Redirect ke halaman checkout
        return redirect()->route('frontend.checkout.index');
    }

    public function updateQuantity(Request $request)
    {
        $item = ItemKeranjang::findOrFail($request->id);
        $item->quantity = $request->quantity;
        $item->save();

        return response()->json(['success' => true]);
    }
}
