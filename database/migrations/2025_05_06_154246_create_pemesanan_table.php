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
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->char('id_pemesanan', 14)->primary(); // Contoh: 'PSN07052025001'
        
            $table->char('id_user', 6); // Mengacu ke ID user seperti 'USR001'
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
        
            $table->text('alamat');
            $table->string('metode_pembayaran',64);
            $table->integer('ongkir')->default(0);
            $table->integer('total_harga');
            $table->integer('status');
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
