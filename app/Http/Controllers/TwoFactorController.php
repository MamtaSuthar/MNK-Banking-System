<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    public function enable2FA(Request $request)
    {
        $user = Auth::user();
        $google2fa = new Google2FA();

        // Generate a valid secret key in Base32 format
        $secret = $google2fa->generateSecretKey();

        // Save the secret key in the database
        $user->two_factor_secret = $secret;
        $user->save();

        // Generate QR code URL
        $QR_Image = $google2fa->getQRCodeUrl('MyApp', $request->user()->email, $secret);

        return view('auth.two-factor-enable', ['QR_Image' => $QR_Image, 'secret' => $secret]);
    }

    public function verify2FA(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        $user = Auth::user();

        if ($user->two_factor_secret == $request->code) {
            session()->put('2fa_enabled', true);

            if (auth()->user()->is_admin) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('home');
            }
        }

        return back()->withErrors(['code' => 'Invalid code.']);
    }
}
