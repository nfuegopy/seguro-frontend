<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
class ApiHelper
{
    /**
     * Realiza una petición POST a la API de NestJS.
     *
     * @param string $endpoint El endpoint al que se llamará (ej. '/auth/login').
     * @param array $data Los datos a enviar en el cuerpo de la petición.
     * @return \Illuminate\Http\Client\Response
     */
    public static function post(string $endpoint, array $data = [])
    {
        $baseUrl = config('app.nestjs_api_url');
        $apiKey = config('app.nestjs_api_key');

        return Http::withHeaders([
            'X-API-KEY' => $apiKey,
            'Accept' => 'application/json',
        ])->post($baseUrl . $endpoint, $data);
    }

    /**
     * Realiza una petición GET a la API de NestJS.
     *
     * @param string $endpoint El endpoint al que se llamará (ej. '/pais').
     * @param array $query Parámetros de consulta (query string).
     * @return \Illuminate\Http\Client\Response
     */
    public static function get(string $endpoint, array $query = [])
    {
        $baseUrl = config('app.nestjs_api_url');
        $apiKey = config('app.nestjs_api_key');

        return Http::withHeaders([
            'X-API-KEY' => $apiKey,
            'Accept' => 'application/json',
        ])->get($baseUrl . $endpoint, $query);
    }


  /**
     * Función centralizada para realizar peticiones REST autenticadas (PATCH, DELETE, etc.).
     * Esta función SÍ incluye el token de autenticación de la sesión.
     *
     * @param string $method El método HTTP (GET, POST, PATCH, DELETE).
     * @param string $endpoint El endpoint al que se llamará.
     * @param array $data Datos para el cuerpo de la petición o query params.
     * @return \Illuminate\Http\Client\Response
     */
    public static function restapi(string $method, string $endpoint, array $data = [])
    {
        $baseUrl = config('app.nestjs_api_url');
        $apiKey = config('app.nestjs_api_key');
        $token = session('nestjs_token'); // Recuperamos el token JWT de la sesión

        $http = Http::withHeaders([
            'X-API-KEY' => $apiKey,
            'Accept' => 'application/json',
        ]);

        // Si existe un token en la sesión, lo añadimos a la cabecera de autorización.
        if ($token) {
            $http->withToken($token);
        }

        $method = Str::lower($method);

        // Realizamos la petición correspondiente según el método.
        return match ($method) {
            'post' => $http->post($baseUrl . $endpoint, $data),
            'patch' => $http->patch($baseUrl . $endpoint, $data),
            'delete' => $http->delete($baseUrl . $endpoint, $data),
            default => $http->get($baseUrl . $endpoint, $data), // 'get' es el caso por defecto
        };
    }

}
