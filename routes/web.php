<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Vinea Comunidad
|--------------------------------------------------------------------------
*/

// Portal Web Parroquial (Página Principal)
Route::get('/', function () {
    return view('home');
})->name('home');

// Autenticación de Usuarios (Invitados)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Rutas Protegidas para Usuarios Autenticados
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Módulo de Gestión de Usuarios y Roles (Exclusivo para Administrador)
    Route::middleware('role:Administrador')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
    });
});
