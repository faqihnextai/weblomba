<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lombas', function (Blueprint $table) {
            $table->json('kategori_kelas')->change();
        });
    }

    public function down(): void
    {
        Schema::table('lombas', function (Blueprint $table) {
            // Jika Anda ingin mengembalikan ke string saat rollback, sesuaikan ini
            $table->string('kategori_kelas')->change();
        });
    }
};