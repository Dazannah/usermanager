<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfInstalled {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        if (!config("app.installed") && ($request->path() != "initial-setup" && !preg_match('/livewire\/.*/', $request->path())))
            return redirect("initial-setup");

        if (config("app.installed") && $request->path() == "initial-setup")
            return redirect("");

        return $next($request);
    }
}
