<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/vcms', [App\Http\Controllers\VcmsController::class, 'index'])->name('vcms.index');
Route::get('/vcms/{slug}/edit', [App\Http\Controllers\VcmsController::class, 'edit'])->name('vcms.edit');
Route::post('/vcms/{slug}/update', [App\Http\Controllers\VcmsController::class, 'update'])->name('vcms.update');
