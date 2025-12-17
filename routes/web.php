<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VcmsController;
use App\Http\Controllers\RedakturController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\RegulationController;
use App\Http\Controllers\DokumenController;
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
    Route::post('/page/update-batch', [VcmsController::class, 'updatePageBatch'])->name('page.update_batch');

    Route::get('/publikasi', [RedakturController::class, 'publication'])->name('publication');

    Route::get('/vcms', [VcmsController::class, 'index'])->name('vcms.index');
    Route::get('/vcms/{slug}/edit', [VcmsController::class, 'edit'])->name('vcms.edit');
    Route::post('/vcms/{slug}/update', [VcmsController::class, 'update'])->name('vcms.update');

    Route::get('/regulasi', [RedakturController::class, 'regulation'])->name('regulation');
    Route::post('/regulasi/save', [RegulationController::class, 'update'])->name('regulation.save');

    Route::get('/dokumen', [DokumenController::class, 'edit'])->name('documents.edit');
    Route::post('/dokumen/update', [DokumenController::class, 'update'])->name('documents.update');

    Route::get('/profil', [RedakturController::class, 'profile'])->name('profile');
    Route::get('/daftar-informasi', [RedakturController::class, 'information'])->name('information');
});

Route::get('/publikasi', [PublicationController::class, 'index'])->name('publikasi.index');
Route::get('/regulasi', [RegulationController::class, 'showRegulation'])->name('regulasi');
Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen');
Route::get('/profil', [ProfileController::class, 'showProfile'])->name('profile');
Route::get('/daftar-informasi', [DaftarInformasiController::class, 'showInformation'])->name('information');