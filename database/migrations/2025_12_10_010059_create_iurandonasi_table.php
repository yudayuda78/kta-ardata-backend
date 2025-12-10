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
        Schema::create('iurandonasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // relasi ke users
            $table->string('nama');
            $table->string('tipe'); // misal: iuran atau donasi
            $table->bigInteger('jumlah'); // jumlah nominal
            $table->string('metode'); // misal: transfer, e-wallet, dll
            $table->string('status')->default('pending'); // pending, sukses, gagal, dll
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iurandonasi');
    }
};
