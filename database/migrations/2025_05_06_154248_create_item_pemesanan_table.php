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
        Schema::create('item_pemesanan', function (Blueprint $table) {
            $table->id();

            $table->char('id_pemesanan', 14); // Foreign key ke pemesanan
            $table->foreign('id_pemesanan')->references('id_pemesanan')->on('pemesanan')->onDelete('cascade');

            $table->char('id_produk', 6); // Foreign key ke produk
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');

            $table->integer('quantity');
            $table->integer('harga_satuan');
            $table->integer('total');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_pemesanan');
    }
};
