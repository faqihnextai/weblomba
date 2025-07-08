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
        Schema::create('pemenangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lomba_id')->constrained('lombas')->onDelete('cascade'); // Foreign key ke tabel lombas
            $table->string('kelas_lomba'); // rendah atau tinggi
            $table->string('nama_pemenang');
            $table->string('kelas_pemenang');
            $table->integer('point_pemenang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemenangs');
    }
};