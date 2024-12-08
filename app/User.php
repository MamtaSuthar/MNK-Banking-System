<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PragmaRX\Google2FA\Google2FA;


class User extends Authenticatable 
{
    use Notifiable;

    protected $fillable = [
        'first_name', 'last_name', 'dob', 'address', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Generate the Two-Factor Secret Key and save it
    public function generateTwoFactorSecret()
    {
        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();

        // Store the encrypted secret in the database
        $this->two_factor_secret = encrypt($secret);
        $this->save();

        return $secret;
    }

    // Verify the Two-Factor Code entered by the user
    public function verifyTwoFactorCode($token)
    {
        if (!$this->two_factor_secret) {
            return false; 
        }

        try {
            // Decrypt the stored secret
            $decryptedSecret = decrypt($this->two_factor_secret); 
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            logger('Decryption failed for two_factor_secret.', ['error' => $e->getMessage()]);
            return false; 
        }
        
        // Verify the code using the Google2FA facade
        if (Google2FA::verifyKey($decryptedSecret, $token)) {
            return true;
        } else {
            return false;
        }
    }

    // Relationships
    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class);
    }

    public function sentTransactions()
    {
        return $this->hasMany(Transaction::class, 'sender_id');
    }

    public function receivedTransactions()
    {
        return $this->hasMany(Transaction::class, 'recipient_id');
    }
}
