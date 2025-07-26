<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->level && Auth::user()->level->nama_level === 'admin') {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Akses ditolak, anda bukan admin.');
    }
}
