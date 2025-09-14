<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermisoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Rutas Públicas (para invitados) ---
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});

// --- Rutas Protegidas (requieren autenticación) ---
Route::middleware('auth')->group(function () {
    //Busqueda de Permisos//
        Route::get('/api/user-menu', [PermisoController::class, 'getMenu'])->name('user.menu');
//Fin Busqueda de Permisos//
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


});

// Redirigir la raíz a la página de login
Route::get('/', function () {
    return redirect()->route('login');
});
