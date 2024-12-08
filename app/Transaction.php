<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillable = [
        'account_id',
        'amount',
        'bank_account_id',
        'sender_id',
        'recipient_id',
        'transaction_type',
        'description',
    ];

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
}
