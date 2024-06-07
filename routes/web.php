<?php

//General
use App\Http\Controllers\Authentification;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\StarController;
use App\Http\Controllers\ProfileController;

//Petugas
use App\Http\Controllers\Petugas\PetugasControllers;
use App\Http\Controllers\Petugas\PeminjamanController;
use App\Http\Controllers\Petugas\PengembalianController;
use App\Http\Controllers\Petugas\PengarangPetugasController;
use App\Http\Controllers\Petugas\PenggunaPetugasController;
use App\Http\Controllers\Petugas\PenerbitPetugasController;
use App\Http\Controllers\Petugas\KategoriPetugasController;

//Admin
use App\Http\Controllers\Admin\PengarangController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\KategoriBukuController;
use App\Http\Controllers\Admin\dashboardAdmin;
use App\Http\Controllers\Admin\PenerbitController;

//User
use App\Http\Controllers\User\BukuController;

// use App\Http\Livewire\Buku;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//admin
Route::resource('kategori', KategoriBukuController::class);
Route::resource('pengarang', PengarangController::class);
Route::resource('penerbit', PenerbitController::class);
Route::resource('buku', BukuController::class);

//petugas
Route::resource('kategoris', KategoriPetugasController::class);
Route::resource('pengarangs', PengarangPetugasController::class);
Route::resource('penerbits', PenerbitPetugasController::class);

// Routes accessible to both admin and users
Route::group(['prefix' => 'account'], function () {
    // Routes for guests (unauthenticated users)
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', [Authentification::class, 'index'])->name('account.login');
        Route::get('landingpage', [LandingPageController::class, 'index']);
        Route::get('register', [Authentification::class, 'register'])->name('account.register');
        Route::post('process-register', [Authentification::class, 'ProcessRegister'])->name('account.ProcessRegister');
        Route::post('authenticate', [Authentification::class, 'authenticate'])->name('account.authenticate');
    });

    // Routes for authenticated users (both admin and regular users)
    Route::group(['middleware' => 'auth'], function () {
        Route::get('logout', [Authentification::class, 'logout'])->name('account.logout');
        Route::resource('dashboard', BukuController::class)->names([
            'index' => 'account.dashboard',
        ]);
        Route::get('book/{id}', [BukuController::class, 'show'])->name('account.show');
        Route::get('pinjam-buku', [PeminjamanController::class, 'index'])->name('pinjam-buku');
        Route::get('pinjam-export', [PeminjamanController::class, 'print'])->name('pinjam-print');
        Route::get('pinjam-buku/{id}', [PeminjamanController::class, 'store'])->name('account.peminjaman');
        Route::get('pinjam-buku/disetujui/{id}', [PeminjamanController::class, 'accept'])->name('pinjam-buku.disetujui');
        Route::get('pinjam-buku/batal/{id}', [PeminjamanController::class, 'remove'])->name('pinjam-buku.batal');

        //profile
        Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
        Route::post('profile/{id}', [ProfileController::class, 'profileedit'])->name('profile-edit');

        //koleksi
        Route::post('/account/post/{id}', [BukuController::class, 'postkoleksi'])->name('account.post');
        Route::post('/account/post-batal/{id}', [BukuController::class, 'batalkoleksi'])->name('account.post-batal');
        Route::get('koleksi', [BukuController::class, 'koleksi'])->name('account.koleksi');

        //rating & Review
        Route::get('add-review', [RatingController::class, 'index'])->name('tampilan.ratings');
        Route::post('rating', [StarController::class, 'rating'])->name('account.rating');

        //UserStatus->Admin
        Route::get('pengguna', [PenggunaController::class, 'data'])->name('pengguna.status');
        Route::get('pengguna-status/{id}', [PenggunaController::class, 'status'])->name('penggunaStatus');
        Route::get('pengguna-status-tolak/{id}', [PenggunaController::class, 'tolak'])->name('penggunaStatusTolak');

        //UserStatus->Petugas
        Route::get('penggunaPetugas', [PenggunaPetugasController::class, 'data'])->name('StatusPetugas');
        Route::get('pengguna-status-petugas/{id}', [PenggunaPetugasController::class, 'status'])->name('penggunaStatusPetugas');

        //PEMINJAMAN USER
        Route::get('pinjamuser', [PeminjamanController::class, 'PeminjamanUser'])->name('PeminjamanUser');
        Route::get('pinjam-buku/kan/{id}', [PeminjamanController::class, 'batal'])->name('pinjam-batal');

        //tolak
        Route::get('pinjam-buku/tolak', [PeminjamanController::class, 'index'])->name('pinjam-tolak');
        Route::get('pinjam-buku/tolak/{id}', [PeminjamanController::class, 'tolak'])->name('pinjam-buku-tolak');

        //pengembalian
        Route::get('pengembalian-buku', [PengembalianController::class, 'index'])->name('pengembalian-buku');
        Route::get('pengembalian-buku/{id}', [PengembalianController::class, 'pengembalian'])->name('pengembalian-buku-baru');

        Route::resource('tampilan', dashboardAdmin::class)->names([
            'index' => 'admin.tampilan',
            'create' => 'tampilan.create',
            'store' => 'tampilan.store',
            'show' => 'tampilan.show',
            'edit' => 'tampilan.edit',
            'update' => 'tampilan.update',
            // 'destroy' => 'tampilan.delete',
        ]);
        Route::put('book/{id}', [dashboardAdmin::class, 'update'])->name('book.update');
        Route::delete('/tampilan/{id}', [PetugasControllers::class, 'destroy'])->name('tampilan.delete');

        Route::resource('lihat', PetugasControllers::class)->names([
            'index' => 'petugas.lihat',
            'create' => 'lihat.create',
            'store' => 'lihat.store',
            'show' => 'lihat.show',
            'edit' => 'lihat.edit',
            'update' => 'lihat.update',
            // 'destroy' => 'lihat.delete',
        ]);
        Route::put('book/{id}', [PetugasControllers::class, 'update'])->name('book.update');
        Route::delete('/lihat/{id}', [PetugasControllers::class, 'destroy'])->name('lihat.delete');
    });

    Route::group(['middleware' => ['auth', 'checkStatus']], function () {
        Route::resource('dashboard', BukuController::class)->names([
            'index' => 'account.dashboard',
        ]);
        Route::resource('tampilan', dashboardAdmin::class)->names([
            'index' => 'admin.tampilan',
        ]);
        Route::resource('lihat', PetugasControllers::class)->names([
            'index' => 'petugas.lihat',
        ]);
    });
});
// Route::get('/buku/{id}', Buku::class);
