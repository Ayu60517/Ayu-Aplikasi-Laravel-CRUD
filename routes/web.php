<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;


Route::get('/mahasiswa/export-excel', [MahasiswaController::class, 'exportExcel'])->name('mahasiswa.export');
Route::resource('mahasiswa', MahasiswaController::class);
Route::get('pdf.blade.php', [MahasiswaController::class, 'cetakPDF'])->name('mahasiswa.cetakPDF');
