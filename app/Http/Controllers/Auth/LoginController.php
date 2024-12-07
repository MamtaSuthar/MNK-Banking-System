<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        if (auth()->user()->is_admin) {
            return '/admin-dashboard'; // Redirect admins to admin dashboard
        }

        return '/home'; // Redirect normal users to home page
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
