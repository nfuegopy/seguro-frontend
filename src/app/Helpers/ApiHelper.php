<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

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

    // Aquí podrías añadir en el futuro métodos para PATCH, DELETE, etc.
}
