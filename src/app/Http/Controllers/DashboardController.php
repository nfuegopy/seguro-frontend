<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Muestra la página principal del dashboard.
     */
    public function index()
    {
        // 1. Recupera los datos del usuario que guardamos durante el login.
        $userData = session('user_data');

        // 2. Carga la vista 'dashboard.blade.php' y le pasa los datos del usuario.
        return view('dashboard', ['userData' => $userData]);
    }
}
