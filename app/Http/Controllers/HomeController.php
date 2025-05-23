<?php

namespace App\Http\Controllers;

use App\Models\ItemKeranjang;
use App\Models\Keranjang;
use App\Models\Menu;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $menu = Menu::orderBy('id_menu', 'asc')->get();
        $produk = Produk::with('menu')->where('status', 1)->get();
        // Set default keranjangCount dulu
        $keranjangCount = 0;


        // Misal ini di controller frontend (contoh: HomeController)
        if (Auth::check()) {
            $idUser = Auth::user()->id_user;
            $keranjang = Keranjang::where('id_user', $idUser)->first();

            if ($keranjang) {
                $keranjangCount = ItemKeranjang::where('id_keranjang', $keranjang->id_keranjang)->count();
            } else {
                $keranjangCount = 0; // Atau sesuaikan sesuai logika kamu
            }
        }

        return view('frontend.v_home.index', [
            'judul' => 'Home',
            'menu' => $menu,
            'produk' => $produk,
            'keranjangCount' => $keranjangCount,
        ]);
    }
}
