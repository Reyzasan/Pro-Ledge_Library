<?php

use Illuminate\Http\Request;
use App\Http\Controllers\api\KategoriController;
use App\Http\Controllers\api\BukuAPIController;
use App\Http\Controllers\api\APIPengarangController;
use App\Http\Controllers\api\APIPenerbitController;
use App\Http\Controllers\api\APIPeminjamanController;
use App\Http\Controllers\api\APIProfilController;
use App\Http\Controllers\api\APIFavoritController;
use App\Http\Controllers\api\APIAutentifikasiController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//kategori
Route::get('/kategoris', [KategoriController::class, 'getAllDataKategori'])->name('kategori');
Route::get('/kategori/{name}', [KategoriController::class, 'GetDataName'])->name('kategori_by_name');

//buku
Route::get('/bukus', [BukuAPIController::class, 'getAllDataBuku'])->middleware(['auth:sanctum']);
Route::get('/bukus/{name}', [BukuAPIController::class, 'GetDataName'])->middleware(['auth:sanctum']);
// Route::get('/bukus/{name}', [BukuAPIController::class, 'GetDataName'])->name('buku_by_name');

//pengarang
Route::get('/pengarang', [APIPengarangController::class, 'getAllDataPengarang'])->name('pengarang');
Route::get('/pengarang/{name}', [APIPengarangController::class, 'GetDataName'])->name('pengarang_by_name');

//penerbit
Route::get('/penerbit', [APIPenerbitController::class, 'getAllDataPenerbit'])->name('penerbit');
Route::get('/penerbit/{name}', [APIPenerbitController::class, 'GetDataName'])->name('penerbit_by_name');

//Autentifikasi
Route::post('/login', [APIAutentifikasiController::class, 'login'])->name('login');
Route::get('/logout', [APIAutentifikasiController::class, 'logout'])->name('logout')->middleware(['auth:sanctum']);
Route::get('/me', [APIAutentifikasiController::class, 'akunlogin'])->name('logout')->middleware(['auth:sanctum']);


