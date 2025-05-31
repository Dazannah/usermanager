<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSysAdmin {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response {
        if (auth()->user()->is_sys_admin())
            return $next($request);

        return redirect("/dashboard")->withErrors(['error' => 'Ehez a menüponthoz nincs jogosultságod.']);
    }
}
