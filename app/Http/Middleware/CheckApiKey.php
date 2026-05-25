<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiKey
{
    /**
     * Middleware básico para proteger los endpoints API.
     * Valida que la petición incluya el encabezado X-API-KEY.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validKey = env('API_KEY', 'clave-demo-actividad-11');

        if ($request->header('X-API-KEY') !== $validKey) {
            return response()->json([
                'message' => 'No autorizado. API Key inválida o ausente.'
            ], 401);
        }

        return $next($request);
    }
}