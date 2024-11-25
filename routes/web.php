<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CouponController;

// Ruta principal (Página de inicio)
Route::get('/', [PageController::class, 'home'])->name('home');

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas del Dashboard (requiere autenticación)
Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/approvals', [DashboardController::class, 'approvals'])->name('dashboard.approvals');
    Route::patch('/approve/{id}', [DashboardController::class, 'approveUser'])->name('dashboard.approve');
    Route::delete('/reject/{id}', [DashboardController::class, 'rejectUser'])->name('dashboard.reject');
});

// Rutas públicas para el registro de usuarios (clientes y empresas)
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

// Rutas protegidas para administradores (gestión de usuarios)
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'createAdmin'])->name('admin.register');
    Route::post('/register', [RegisteredUserController::class, 'storeAdmin']);
});

// Rutas para gestión de cupones
Route::get('/coupons/create', [CouponController::class, 'create'])->name('coupons.create');
Route::post('/coupons', [CouponController::class, 'store'])->name('coupons.store');
