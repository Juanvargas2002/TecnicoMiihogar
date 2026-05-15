<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\OrdenServicioController;
use App\Http\Controllers\ImagenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

Route::view('/', 'welcome')->name('welcome');

Route::get('/ordenes/seguimiento', [OrdenServicioController::class, 'seguimiento'])->name('ordenes.seguimiento');
Route::post('/ordenes/buscar', [OrdenServicioController::class, 'buscar'])->name('ordenes.buscar');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('ordenes/{orden}/pdf', [OrdenServicioController::class, 'descargarPdf'])->name('ordenes.pdf');
    Route::resource('ordenes', OrdenServicioController::class);
    Route::resource('imagenes', ImagenController::class);
    Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');
});

Route::middleware('auth', 'role:Recepcionista,Administrador')->group(function () {
    Route::resource('clientes', ClienteController::class);
    Route::resource('equipos', EquipoController::class);
});

Route::middleware('auth', 'role:Administrador')->group(function () {
    Route::resource('usuarios', UsuarioController::class);
});

require __DIR__.'/auth.php';
