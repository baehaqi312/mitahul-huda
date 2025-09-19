<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DashboardController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('users', UsersController::class)->middleware(['auth', 'verified']);


use App\Http\Controllers\BarangPeminjamanController;

Route::resource('barang', BarangPeminjamanController::class)->middleware(['auth', 'verified']);
Route::post('barang/{id}/return', [BarangPeminjamanController::class, 'returnItem'])->middleware(['auth', 'verified'])->name('barang.return');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
