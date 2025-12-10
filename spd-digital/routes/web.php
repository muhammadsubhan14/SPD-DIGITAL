<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Halaman utama → langsung ke login
Route::get('/', function () {
    return redirect('/login');
});


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Proses login
Route::post('/login', [AuthController::class, 'login']);

// Tampilkan form register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

// Proses register
Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
