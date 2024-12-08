<?php
namespace App\Http\Controllers;

use App\User;
use App\Transaction;
use App\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FundTransferController extends Controller
{
    public function index()
    {
        return view('user.transfer');
    }


    public function store(Request $request)
    {
        $request->validate([
            'recipient_account_number' => 'required|exists:bank_accounts,account_number',
            'amount' => 'required|numeric|min:1',
        ]);
       
        $sender = Auth::user();
        $recipientAccount = BankAccount::where('account_number', $request->recipient_account_number)->first();
        $amount = $request->amount;

        $account_details = User::where('id', Auth::user()->id)->with('bankAccounts')->first();
        if ($account_details->balance < $amount) {
            return back()->withErrors(['amount' => 'Insufficient balance for this transfer.']);
        }

        
        DB::transaction(function () use ($sender, $recipient, $amount) {
            // Deduct amount from sender
            $sender->balance -= $amount;
            $sender->save();

            // Add amount to recipient
            $recipient->balance += $amount;
            $recipient->save();

            Transaction::create([
                'sender_id' => $sender->id,
                'recipient_id' => $recipient->id,
                'amount' => $amount,
                'description' => "Transferred to {$recipient->account_number}",
            ]);

            Transaction::create([
                'sender_id' => $recipient->id,
                'recipient_id' => $sender->id,
                'amount' => $amount,
                'description' => "Received from {$sender->account_number}",
            ]);
        });

        return redirect()->route('transfer.index')->with('success', 'Fund transfer successful!');
    }
}
