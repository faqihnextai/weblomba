<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lomba;
use App\Models\Pemenang;

class AppController extends Controller
{
    /**
     * Menampilkan form pencatatan pemenang.
     */
    public function showFormPemenang()
    {
        $lombas = Lomba::all();
        return view('form_pemenang', compact('lombas'));
    }

    /**
     * Menampilkan daftar pemenang.
     */
    public function showDaftarPemenang()
    {
        // Ambil semua pemenang dari database, dengan memuat relasi 'lomba'
        $pemenangs = Pemenang::with('lomba')->get();
        return view('pemenang_user_view', compact('pemenangs'));
    }

    /**
     * Menampilkan halaman kocok klasifikasi.
     */
    public function showKocokKlasifikasi()
    {
        return view('klasifikasi');
    }

    /**
     * Memproses submit form pencatatan pemenang.
     */
    public function submitPemenang(Request $request)
    {
        // Validasi data yang masuk dari form
        $request->validate([
            'nama_lomba' => 'required|exists:lombas,id',
            'kelas_lomba' => 'required|in:rendah,tinggi', // Sesuaikan jika ada kategori lain
            'nama_pemenang' => 'required|string|max:255',
            'kelas_pemenang' => 'required|string|max:255',
            'point_pemenang' => 'required|integer|min:0',
        ]);

        try {
            // Simpan data pemenang ke database
            Pemenang::create([
                'lomba_id' => $request->nama_lomba,
                'kelas_lomba' => $request->kelas_lomba,
                'nama_pemenang' => $request->nama_pemenang,
                'kelas_pemenang' => $request->kelas_pemenang,
                'point_pemenang' => $request->point_pemenang,
            ]);

            // Redirect kembali dengan pesan sukses
            return redirect()->back()->with('success', 'Pencatatan pemenang berhasil!');
        } catch (\Exception $e) {
            // Tangani error jika ada masalah saat menyimpan data
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal mencatat pemenang: ' . $e->getMessage()]);
        }
    }
}
