<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Verifica que el usuario autenticado tenga uno de los roles permitidos.
     *
     * Ejemplos de uso en rutas:
     * - role:admin
     * - role:doctor
     * - role:admin,doctor
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Si no hay usuario autenticado, se bloquea el acceso.
        if (! $request->user()) {
            abort(403, 'Usuario no autenticado.');
        }

        // Si el rol del usuario no está dentro de los roles permitidos,
        // se bloquea el acceso con error 403.
        if (! in_array($request->user()->role, $roles)) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}