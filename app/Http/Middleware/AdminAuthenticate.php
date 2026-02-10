<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guard = empty($guards) ? 'admin' : $guards[0];

        if (!Auth::guard($guard)->check()) {
            return redirect()->route('admin.login');
        }

        // Vérifier que l'admin est actif (si vous ajoutez ce champ plus tard)
        // if (Auth::guard($guard)->user()->is_active !== true) {
        //     Auth::guard($guard)->logout();
        //     return redirect()->route('admin.login')->with('error', 'Votre compte a été désactivé.');
        // }

        return $next($request);
    }
}