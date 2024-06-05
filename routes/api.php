<?php

use Illuminate\Http\Request;
use App\Http\Controllers\api\KategoriController;
use App\Http\Controllers\api\BukuAPIController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//kategori
Route::get('/kategoris', [KategoriController::class, 'getAllDataKategori'])->name('kategori');

//buku
Route::get('/bukus', [BukuAPIController::class, 'getAllDataBuku'])->name('buku');

