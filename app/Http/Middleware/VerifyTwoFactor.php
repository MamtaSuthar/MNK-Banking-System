<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyTwoFactor
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() && !session()->has('2fa_enabled')) {
            return redirect()->route('two-factor.enable');
        }

        return $next($request);
    }
}
