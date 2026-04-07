<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminLapangan\DashboardController;
use App\Http\Controllers\AdminLapangan\LaporanKonservasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return "API SIKOMA BERJALAN";
});

/*
|--------------------------------------------------------------------------
| Default Dashboard (Breeze)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| AdminLapangan Routes (BACKEND - PUNYA KAMU)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('AdminLapangan')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('AdminLapangan.dashboard');

    Route::get('/laporan-konservasi', [LaporanKonservasiController::class, 'index'])
        ->name('AdminLapangan.laporan.index');

    Route::post('/laporan-konservasi', [LaporanKonservasiController::class, 'store'])
        ->name('AdminLapangan.laporan.store');
});

/*
|--------------------------------------------------------------------------
| Profile Routes (Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
//require __DIR__.'/auth.php';
