<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class mid1
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $us = $request->input("usuario");
        // $pas = $request->input("password");


        if (1 == 2) {
            return response()->json([
                "mensaje" => "Acceso denegado por mid1"

            ], 401);
        }
        return $next($request);
    }
}

