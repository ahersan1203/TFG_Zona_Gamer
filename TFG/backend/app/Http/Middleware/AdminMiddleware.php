<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->rol_id !== 1) {
            return response()->json([
                'message' => 'Acceso no autorizado'
             
            ], (403));
            
        }

        return $next($request);
    }
}