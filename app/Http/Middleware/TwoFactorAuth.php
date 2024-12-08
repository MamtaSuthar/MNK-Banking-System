<?php
// app/Http/Middleware/TwoFactorAuth.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorAuth
{

    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and 2FA is not completed
        if (Auth::check() && !session()->has('2fa_enabled')) {
            return redirect()->route('two-factor.enable'); 
        }

        return $next($request);
    }
}
