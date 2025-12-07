<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VcmsController;
use App\Http\Controllers\RedakturController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\RegulationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DaftarInformasiController;


Route::get('/', [VcmsController::class, 'showHome'])->name('home');


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {


    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('users', UserController::class)->except(['create', 'edit', 'show']);

});


Route::middleware(['auth', 'can:redaktur'])->prefix('redaktur')->name('redaktur.')->group(function () {


    Route::get('/dashboard', [RedakturController::class, 'dashboard'])->name('dashboard');

    // 2. LOGIC SIMPAN / UPDATE (Pakai VcmsController)
    // Ini route yang dipanggil oleh Javascript (AJAX) saat tombol Save diklik
    Route::post('/page/update-batch', [VcmsController::class, 'updatePageBatch'])->name('page.update_batch');


    Route::get('/publikasi', [RedakturController::class, 'publication'])->name('publication');
    // --- INTEGRASI ROUTE VCMS KAMU DI SINI ---

    // URL jadi: /redaktur/vcms
    // Nama route jadi: redaktur.vcms.index
    Route::get('/vcms', [VcmsController::class, 'index'])->name('vcms.index');

    // URL jadi: /redaktur/vcms/{slug}/edit
    // Nama route jadi: redaktur.vcms.edit
    Route::get('/vcms/{slug}/edit', [VcmsController::class, 'edit'])->name('vcms.edit');

    // URL jadi: /redaktur/vcms/{slug}/update
    // Nama route jadi: redaktur.vcms.update
    Route::post('/vcms/{slug}/update', [VcmsController::class, 'update'])->name('vcms.update');
    Route::get('/regulasi', [RedakturController::class, 'regulation'])->name('regulation');
    // ROUTE BARU: SIMPAN REGULASI (POST)
    Route::post('/regulasi/save', [RegulationController::class, 'update'])->name('regulation.save');

    Route::get('/profil', [RedakturController::class, 'profile'])->name('profile');
    Route::get('/daftar-informasi', [RedakturController::class, 'information'])->name('information');
});

Route::get('/publikasi', [PublicationController::class, 'index'])->name('publikasi.index');
Route::get('/regulasi', [RegulationController::class, 'showRegulation'])->name('regulasi');
Route::get('/profil', [ProfileController::class, 'showProfile'])->name('profile');
Route::get('/daftar-informasi', [DaftarInformasiController::class, 'showInformation'])->name('information');
