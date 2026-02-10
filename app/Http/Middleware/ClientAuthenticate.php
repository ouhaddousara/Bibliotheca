<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ClientAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guard = empty($guards) ? 'client' : $guards[0];

        if (!Auth::guard($guard)->check()) {
            return redirect()->route('client.login');
        }

        // Vérifier que le membre est actif
        if (Auth::guard($guard)->user()->is_active !== true) {
            Auth::guard($guard)->logout();
            return redirect()->route('client.login')
                ->with('error', 'Votre compte a été désactivé. Veuillez contacter l\'administrateur.');
        }

        return $next($request);
    }
}