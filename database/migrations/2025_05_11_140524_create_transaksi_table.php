<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->char('id_transaksi', 14)->primary(); // Kolom ID transaksi
            $table->char('id_pemesanan', 14); // Kolom ID pemesanan
            $table->foreign('id_pemesanan')->references('id_pemesanan')->on('pemesanan'); // Relasi dengan tabel pemesanan
            $table->enum('status_pembayaran', ['Pending', 'Sukses', 'Gagal']); // Status pembayaran (pending, sukses, gagal)
            $table->integer('jumlah_bayar'); // Jumlah pembayaran yang dilakukan
            $table->string('invoice_url', 255)->nullable(); 
            $table->timestamps(); // Waktu transaksi dibuat dan diperbarui
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
