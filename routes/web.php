<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\CarritoController;

// Ruta principal (Página de inicio)
Route::get('/', [PageController::class, 'home'])->name('home');

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas del Dashboard (solo accesibles para administradores)
Route::prefix('dashboard')->middleware(['auth', 'admin'])->group(function () {
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

// Ruta para gestión de ofertas (cupones) accesible solo para empresas
Route::middleware(['auth', 'role:empresa'])->group(function () {
    Route::get('/offers', [OfferController::class, 'create'])->name('offers.create'); // Página principal de registro de cupones
    Route::post('/offers', [OfferController::class, 'store'])->name('offers.store'); // Guardar nuevos cupones
});

// Rutas para el carrito de compras accesibles solo para clientes
Route::middleware(['auth', 'role:cliente'])->group(function () {
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index'); // Ver carrito
    Route::patch('/carrito/actualizar/{id}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar'); // Actualizar cantidad en el carrito
    Route::delete('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar'); // Eliminar del carrito
    Route::get('/carrito/pagar', [CarritoController::class, 'pagar'])->name('carrito.pagar'); // Pasarela de pago
    Route::post('/carrito/pagar/procesar', [CarritoController::class, 'procesarPago'])->name('carrito.pagar.procesar'); // Procesar pago
});
