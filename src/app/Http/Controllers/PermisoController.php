<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PermisoController extends Controller
{
    /**
     * Obtiene el menú de navegación y los permisos para el rol del usuario actual.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getMenu(Request $request): JsonResponse
    {
        // 1. Recuperamos los datos del usuario de la sesión.
        $userData = $request->session()->get('user_data');

        // 2. Verificamos si tenemos el ID del rol. Si no, devolvemos un error.
        if (empty($userData) || empty($userData['rol_id'])) {
            return response()->json([
                'error' => 'No autorizado',
                'message' => 'No se encontró el rol del usuario en la sesión.'
            ], 401);
        }

        $rolId = $userData['rol_id'];

        // 3. Construimos el endpoint específico para el rol del usuario.
        $endpoint = "/roles/{$rolId}/menus";

        // 4. Usamos nuestro nuevo método 'restapi' para hacer la llamada.
        //    Este método ya incluye el token JWT que guardamos en la sesión.
        $response = ApiHelper::restapi('GET', $endpoint);

        // 5. Si la API falla, devolvemos una respuesta de error.
        if ($response->failed()) {
            return response()->json([
                'error' => 'Error al obtener el menú',
                'message' => 'No se pudo comunicar con el servicio de permisos.'
            ], $response->status());
        }

        // 6. Si todo sale bien, devolvemos los datos del menú en formato JSON.
        return response()->json($response->json());
    }
}
