<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PragmaRX\Google2FA\Google2FA;

class User extends Authenticatable 
{
    use  Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'dob','address' ,'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function generateTwoFactorSecret()
    {
        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();
    
        $this->two_factor_secret = encrypt($secret); 
        $this->save();
    
        return $secret;
    }
    
    public function verifyTwoFactorCode($token)
    {
        if (!$this->two_factor_secret) {
            return false; 
        }
    
        try {
            $decryptedSecret = decrypt($this->two_factor_secret); 
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            logger('Decryption failed for two_factor_secret.', ['error' => $e->getMessage()]);
            return false; 
        }
        
        if($decryptedSecret == $token){
            return true;
        }else{
            return false;
        }
    }

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
