<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    // Check of de gebruiker is ingelogd EN of hij admin is
    if (auth()->check() && auth()->user()->is_admin) {
        return $next($request); // Je bent admin, loop maar door!
    }

    // Geen admin? Stuur ze terug naar de home met een foutmelding
    return redirect('/')->with('error', 'Je hebt geen toegang tot deze pagina.');
    }
}
