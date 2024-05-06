<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\akunController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriBukuController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\Authentification;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('pengguna', PenggunaController::class);

Route::resource('akun', akunController::class);

Route::resource('buku', BukuController::class);

Route::resource('kategori', KategoriBukuController::class);

Route::get('authe',[Authentification::class, 'index']);
Route::post('authe/login',[Authentification::class, 'login']);
Route::get('authe/logout',[Authentification::class, 'logout']);
Route::get('authe/register',[Authentification::class, 'register']);
Route::post('authe/create',[Authentification::class, 'create']);

