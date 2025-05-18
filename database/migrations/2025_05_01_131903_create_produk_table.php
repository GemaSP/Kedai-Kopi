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
        Schema::create('produk', function (Blueprint $table) {
            $table->char('id_produk', 6)->primary();  // ID dengan format seperti 'PRD001'
            $table->char('id_menu', 4);  // Menambahkan kolom menu_id yang terhubung dengan id di tabel menu
            $table->string('nama', 64);  // Nama produk
            $table->text('deskripsi')->nullable();  // Deskripsi produk, dapat kosong
            $table->integer('harga');  // Harga produk
            $table->string('foto', 255)->nullable();  // Nama file foto produk, bisa kosong
            $table->integer('status');  // Status produk
            $table->timestamps();  // Menambahkan created_at dan updated_at

            $table->foreign('id_menu')->references('id_menu')->on('menu')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
