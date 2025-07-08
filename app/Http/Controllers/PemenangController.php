<?php

namespace App\Http\Controllers;

use App\Models\Pemenang;
use Illuminate\Http\Request;

class PemenangController extends Controller
{
    public function index()
    {
        $data = Pemenang::with('lomba:id,nama_lomba')
            ->latest()
            ->get()
            ->map(function ($p) {
                return [
                    'nama_lomba' => $p->lomba->nama_lomba,
                    'kelas_lomba' => $p->kelas_lomba,
                    'nama_pemenang' => $p->nama_pemenang,
                    'kelas_pemenang' => $p->kelas_pemenang,
                    'point_pemenang' => $p->point_pemenang,
                ];
            });

        return response()->json($data);
    }
}

