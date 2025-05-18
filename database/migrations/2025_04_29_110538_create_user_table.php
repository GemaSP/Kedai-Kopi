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
        Schema::create('user', function (Blueprint $table) {
            $table->char('id_user', 6)->primary(); // ID seperti 'USR001', cukup 6 karakter
            $table->string('nama', 64);           
            $table->string('email', 64)->unique(); 
            $table->string('password', 255); 
            $table->integer('status');
            $table->integer('role');
            $table->string('foto', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
