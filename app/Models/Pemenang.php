<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemenang extends Model
{
    use HasFactory;

    protected $fillable = [
        'lomba_id',
        'kelas_lomba',
        'nama_pemenang',
        'kelas_pemenang',
        'point_pemenang',
    ];

    // Definisikan relasi dengan model Lomba
    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }
}