<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    public function enableTwoFactor()
    {
        $user = Auth::user();
        $google2fa = new Google2FA();
        $secret = $user->generateTwoFactorSecret();

        $QRImage = $google2fa->getQRCodeUrl(
            config('app.name'), 
            $user->email, 
            $secret
        );

        return view('auth.two-factor-enable', ['QRImage' => $QRImage, 'secret' => $secret]);
    }

    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);
      
        $user = Auth::user();
        if ($user->verifyTwoFactorCode($request->code)) {
            session()->put('2fa_enabled', true);

            if (auth()->user()->is_admin) {
                return redirect()->route('admin.dashboard');
            }else{
                return redirect()->route('home');
            }
          
        }

        return back()->withErrors(['code' => 'Invalid code.']);
    }
}
