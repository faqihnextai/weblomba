<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lomba extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lomba',
        'kategori_kelas',
    ];

    // Tambahkan casting untuk kolom kategori_kelas
    protected $casts = [
        'kategori_kelas' => 'array',
    ];
}
