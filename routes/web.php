<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route Front End
// Route Autentikasi
Route::get('/', [HomeController::class, 'index'])->name('frontend.home');
Route::get('login', [AuthController::class, 'loginCustomer'])->name('frontend.login');
Route::get('register', [AuthController::class, 'registerCustomer'])->name('frontend.register');
Route::post('login', [AuthController::class, 'storeLoginCustomer'])->name('frontend.storeLogin');
Route::post('registrasi', [AuthController::class, 'storeRegisterCustomer'])->name('frontend.storeRegister');
Route::post('logout', [AuthController::class, 'logoutCustomer'])->name('frontend.logout');

// Route Home
Route::resource('keranjang', KeranjangController::class)->names('frontend.keranjang');
Route::post('keranjang/checkout', [KeranjangController::class, 'checkout'])->name('frontend.keranjang.checkout');
Route::post('checkout/process', [CheckoutController::class, 'process'])->name('frontend.checkout.process');
Route::resource('checkout', CheckoutController::class)->names('frontend.checkout');
Route::get('pesananSaya', [PesananController::class, 'index'])->name('frontend.pesanan.index');
Route::post('pesananSaya/{id}/konfirmasi', [PesananController::class, 'konfirmasi'])->name('frontend.pesanan.konfirmasi');
Route::post('pesananSaya/{id}/batalkan', [PesananController::class, 'batalkan'])->name('frontend.pesanan.batal');
Route::post('checkout/cod', [CheckoutController::class, 'codCheckout'])->name('frontend.checkout.cod');


// Route Back End
Route::middleware(['guest'])->group(function () {
    Route::get('backend/login', [AuthController::class, 'index'])->name('backend.login');
    Route::get('backend/registrasi', [AuthController::class, 'registrasi'])->name('backend.registrasi');
    Route::get('backend/lupaPassword', [AuthController::class, 'lupaPassword'])->name('backend.lupaPassword');
});

Route::post('backend/login', [AuthController::class, 'storeLogin'])->name('backend.storeLogin');
Route::post('backend/registrasi', [AuthController::class, 'storeRegistrasi'])->name('backend.storeRegistrasi');
Route::post('backend/logout', [AuthController::class, 'logout'])->name('backend.logout');

Route::get('backend/dashboard', [DashboardController::class, 'index'])->name('backend.dashboard');
Route::resource('backend/user', UserController::class)->names('backend.user');
Route::resource('backend/menu', MenuController::class)->names('backend.menu');
Route::resource('backend/produk', ProdukController::class)->names('backend.produk');
Route::resource('backend/profil', ProfilController::class)->names('backend.profil');
Route::resource('backend/pemesanan', PemesananController::class)->names('backend.pemesanan');
Route::resource('backend/transaksi', TransaksiController::class)->names('backend.transaksi');
Route::patch('backend/user/status/{id}', [UserController::class, 'toggleStatus'])->name('backend.user.toggleStatus');

Route::post('pemesanan/{id}/konfirmasi', [PemesananController::class, 'konfirmasi'])->name('backend.pemesanan.konfirmasi');
Route::post('pemesanan/{id}/kirim', [PemesananController::class, 'kirim'])->name('backend.pemesanan.kirim');
Route::post('pemesanan/{id}/selesai', [PemesananController::class, 'selesai'])->name('backend.pemesanan.selesai');
Route::post('pemesanan/{id}/batalkan', [PemesananController::class, 'batalkan'])->name('backend.pemesanan.batalkan');

Route::post('/midtrans/callback', [TransaksiController::class, 'store'])->name('midtrans.callback');
Route::get('/transaksi/finish', [TransaksiController::class, 'finish'])->name('transaksi.finish');
Route::post('/get/id', [CheckoutController::class, '_getTransactionId'])->name('checkout.getId');
Route::get('/backend/laporan', [LaporanController::class, 'index'])->name('backend.laporan.index');
Route::post('/backend/laporan/cetak', [LaporanController::class, 'cetak'])->name('backend.laporan.cetak');
Route::resource('backend/pelanggan', PelangganController::class)->names('backend.pelanggan');