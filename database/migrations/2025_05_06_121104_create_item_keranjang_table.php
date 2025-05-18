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
        Schema::create('item_keranjang', function (Blueprint $table) {
            $table->id(); // ID item keranjang (bisa auto-increment)
            
            $table->char('id_keranjang', 9); // Sesuai dengan format 'KRJ005001'
            $table->foreign('id_keranjang')->references('id_keranjang')->on('keranjang')->onDelete('cascade');
        
            $table->char('id_produk', 6); // Sesuai dengan format 'PRD000'
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
        
            $table->unsignedInteger('quantity')->default(1); // Jumlah produk dalam keranjang
            $table->timestamps();
        
            $table->unique(['id_keranjang', 'id_produk']); // Satu produk hanya boleh sekali per keranjang
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_keranjang');
    }
};
