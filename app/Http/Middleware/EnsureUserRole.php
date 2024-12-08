<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_admin == 1) {
            return redirect('/admin/dashboard')->with('error', 'Admins are not allowed to access this section.');
        }

        return $next($request);
    }
}
