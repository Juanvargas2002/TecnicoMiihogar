<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkRol
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Verificar si el usuario está autenticado
        if (! $request->user()) {
            return redirect('login');
        }

        // 2. Verificar si el rol del usuario coincide con alguno de los roles permitidos
        // Si no se pasó ningún rol al middleware, permitimos el acceso (o denegamos, según la lógica deseada, aquí permito para evitar bloqueos accidentales si se olvida el parámetro)
        if (empty($roles)) {
             return $next($request);
        }

        // Convertir roles a array y verificar
        foreach($roles as $role) {
            if ($request->user()->rol === $role) {
                return $next($request);
            }
        }

        // 3. Si no tiene el rol, abortar con error 403 (Prohibido)
        abort(403, 'No tienes permisos para acceder a esta sección.');
    }
}
