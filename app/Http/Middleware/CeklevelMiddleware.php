<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CeklevelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $level)
    {
        if (!session('logged_in') || session('level') != $level) {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }
        return $next($request);
    }
}
