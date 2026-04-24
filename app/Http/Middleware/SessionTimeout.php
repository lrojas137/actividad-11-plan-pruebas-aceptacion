<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SessionTimeout
{
    /**
     * Tiempo máximo de inactividad en segundos.
     * 900 segundos equivalen a 15 minutos.
     */
    
    protected int $timeout = 900;

    /**
     * Verifica si la sesión del usuario expiró por inactividad.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $lastActivity = session('last_activity');

            if ($lastActivity && (time() - $lastActivity > $this->timeout)) {
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()
                    ->route('login')
                    ->withErrors([
                        'email' => 'Tu sesión expiró por inactividad. Inicia sesión nuevamente.',
                    ]);
            }

            session(['last_activity' => time()]);
        }

        return $next($request);
    }
}