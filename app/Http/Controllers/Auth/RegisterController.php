<?php

namespace App\Http\Controllers\Auth;

use App\User; 
use App\BankAccount; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date|before:today',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'address' => $data['address'],
            'dob' => $data['dob'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

     
        BankAccount::create([
            'user_id' => $user->id,
            'account_number' => $this->generateUniqueAccountNumber(),
            'balance' => 10000, // Initial balance of 10,000 USD
            'account_type' => 'savings',
            'is_active' => true,
        ]);

        return $user;
    }

    /**
     * Generate a unique account number.
     *
     * @return int
     */
    private function generateUniqueAccountNumber()
    {
        do {
            $accountNumber = mt_rand(1000000000, 9999999999); // Generate a 10-digit account number
        } while (BankAccount::where('account_number', $accountNumber)->exists());

        return $accountNumber;
    }
}
