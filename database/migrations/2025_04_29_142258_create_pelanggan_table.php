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
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->char('id_pelanggan', 6)->primary();  // ID dengan format seperti 'PEL001'
            $table->char('id_user', 6);  // Kolom untuk menghubungkan dengan 'user'
            $table->string('nama', 64); // Nama pelanggan biasanya tidak lebih dari 100 karakter
            $table->string('telepon', 15);
            $table->text('alamat');
            $table->timestamps();

            // Menambahkan foreign key untuk menghubungkan 'pelanggan' dengan 'user'
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
