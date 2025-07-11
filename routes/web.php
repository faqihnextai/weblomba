<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route untuk sisi user
// Route untuk halaman utama (Form Pemenang)
Route::get('/', [AppController::class, 'showFormPemenang'])->name('form.pemenang');

// Route untuk submit form pemenang
Route::post('/submit-pemenang', [AppController::class, 'submitPemenang'])->name('user.submit.pemenang');

// Route untuk halaman Daftar Pemenang
Route::get('/daftar-pemenang', [AppController::class, 'showDaftarPemenang'])->name('daftar.pemenang');

// Route untuk halaman Kocok Klasifikasi
Route::get('/kocok-klasifikasi', [AppController::class, 'showKocokKlasifikasi'])->name('kocok.klasifikasi');

// Route untuk sisi admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/lomba/buat', [AdminController::class, 'createLombaForm'])->name('lomba.create');
    Route::post('/lomba', [AdminController::class, 'storeLomba'])->name('lomba.store');
    Route::get('/pemenang', [AdminController::class, 'showPemenang'])->name('pemenang'); // Route baru untuk daftar pemenang
});