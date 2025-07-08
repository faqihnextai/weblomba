<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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
Route::get('/', [UserController::class, 'showForm'])->name('user.form');
Route::post('/submit-pemenang', [UserController::class, 'submitPemenang'])->name('user.submit.pemenang'); // Tambahkan ini nanti untuk menyimpan data pemenang

// Route untuk sisi admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/lomba/buat', [AdminController::class, 'createLombaForm'])->name('lomba.create');
    Route::post('/lomba', [AdminController::class, 'storeLomba'])->name('lomba.store');
    Route::get('/pemenang', [AdminController::class, 'showPemenang'])->name('pemenang'); // Route baru untuk daftar pemenang
});