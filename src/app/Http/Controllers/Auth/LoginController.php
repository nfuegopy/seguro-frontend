<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Muestra la vista del formulario de login.
     */
    public function create()
    {
        // Carga el archivo Blade que contiene el div para nuestra app de Vue.
        return view('auth.login');
    }

    /**
     * Maneja el intento de autenticación del usuario.
     */
    public function store(Request $request)
    {
        // 1. Valida que el email y la contraseña no estén vacíos.
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Usa nuestro ApiHelper para llamar al endpoint de login de NestJS.
        $response = ApiHelper::post('/auth/login', $credentials);

        // 3. Si NestJS devuelve un error, se lo mostramos al usuario.
        if ($response->failed()) {
            throw ValidationException::withMessages([
                'email' => 'Las credenciales proporcionadas no son correctas.',
            ]);
        }

        // 4. Si la respuesta es exitosa, extraemos los datos del usuario.
        $apiUser = $response->json()['user'];

        // 5. Buscamos si el usuario ya existe en la BD de Laravel; si no, lo creamos.
        $user = User::updateOrCreate(
            ['email' => $apiUser['email']],
            [
                'name' => $apiUser['nombre'] . ' ' . $apiUser['apellido'],
                'password' => bcrypt('password-temporal-no-usado')
            ]
        );

        // 6. Iniciamos la sesión del usuario en Laravel.
        Auth::login($user, $request->boolean('remember'));

        // 7. Guardamos los datos importantes en la sesión para reutilizarlos.
        $request->session()->put('user_data', [
            'nombreCompleto' => $apiUser['nombre'] . ' ' . $apiUser['apellido'],
            'rol' => $apiUser['rol']['nombre'],

            'rol_id' => $apiUser['rol']['id']
        ]);
        $request->session()->put('nestjs_token', $response->json()['access_token']);

        // 8. Regeneramos la sesión por seguridad y redirigimos al dashboard.
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }
}
