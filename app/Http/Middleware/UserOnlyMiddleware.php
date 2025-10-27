<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserOnlyMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_admin) {
            // Jika admin, redirect ke admin dashboard
            return redirect()->route('admin.dashboard')->with('error', 'Admins cannot create listings. Use the admin panel to manage listings.');
        }

        return $next($request);
    }
}