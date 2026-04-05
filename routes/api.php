<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\Admin\LaporanKonservasiController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// =======================
// ✅ REGISTER
// =======================
Route::post('/register', function (Request $request) {

    $request->validate([
        'full_name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6'
    ]);

    $user = User::create([
        'name' => $request->full_name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'admin_lapangan' // default role
    ]);

    return response()->json([
        'message' => 'Register berhasil',
        'user' => $user
    ]);
});


// =======================
// ✅ LOGIN (PAKAI CONTROLLER)
// =======================
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::get('/edukasi', [EdukasiController::class, 'index']);

// =======================
// ✅ DASHBOARD
// =======================
Route::get('/admin/dashboard', [DashboardController::class, 'index']);

// API laporan konservasi
Route::get('/laporan', [LaporanKonservasiController::class, 'index']);
Route::post('/laporan', [LaporanKonservasiController::class, 'store']);
Route::put('/laporan/{id}', [LaporanKonservasiController::class, 'update']);
Route::delete('/laporan/{id}', [LaporanKonservasiController::class, 'destroy']);

// =======================
// ✅ TEST API (OPTIONAL)
// =======================
Route::get('/test', function () {
    return response()->json([
        'message' => 'API jalan'
    ]);
});