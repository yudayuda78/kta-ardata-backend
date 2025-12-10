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
        Schema::create('buktiiuran', function (Blueprint $table) {
           $table->id();
            $table->foreignId('iuran_id')->constrained('iurandonasi')->onDelete('cascade');
            $table->string('image'); // path atau URL gambar
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buktiiuran');
    }
};
