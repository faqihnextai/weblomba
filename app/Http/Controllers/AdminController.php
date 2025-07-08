<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lomba;
use App\Models\Pemenang; // Pastikan model Pemenang sudah diimpor

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalLomba = Lomba::count();
        $totalPemenang = Pemenang::count();
        return view('admin.dashboard', compact('totalLomba', 'totalPemenang'));
    }

    public function createLombaForm()
    {
        return view('admin.lomba_form');
    }

    public function storeLomba(Request $request)
    {
        $request->validate([
            'nama_lomba' => 'required|string|max:255',
            'kategori_kelas' => 'required|array|min:1',
            'kategori_kelas.*' => 'in:rendah,tinggi',
        ]);

        try {
            Lomba::create([
                'nama_lomba' => $request->nama_lomba,
                'kategori_kelas' => $request->kategori_kelas,
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Lomba berhasil didaftarkan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal mendaftarkan lomba: ' . $e->getMessage()]);
        }
    }

    public function showPemenang()
    {
        // Ambil semua pemenang beserta data lomba terkait (eager loading)
        // Ini akan mengambil data dari tabel 'pemenangs' dan secara otomatis
        // memuat data 'lomba' yang berelasi.
        $pemenangs = Pemenang::with('lomba')->get();
        return view('admin.pemenang', compact('pemenangs'));
    }
}
