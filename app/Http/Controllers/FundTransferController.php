<?php
namespace App\Http\Controllers;

use App\User;
use App\Transaction;
use App\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\CurrencyExchangeService;

class FundTransferController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyExchangeService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

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
        $senderAccount = BankAccount::where('user_id', $sender->id)->first();
        $recipientAccount = BankAccount::where('account_number', $request->recipient_account_number)->first();
        $amount = $request->amount;

        // Check if sender has sufficient balance
        if ($senderAccount->balance < $amount) {
            return back()->withErrors(['amount' => 'Insufficient balance for this transfer.']);
        }

        DB::transaction(function () use ($senderAccount, $recipientAccount, $amount, $sender) {
            // Deduct amount from sender's account
            $senderAccount->balance -= $amount;
            $senderAccount->save();

            // Add amount to recipient's account
            $recipientAccount->balance += $amount;
            $recipientAccount->save();

            // Log transactions
                Transaction::create([
                    'sender_id' => $sender->id,
                    'bank_account_id' => $senderAccount->id, // sender's bank account ID
                    'recipient_id' => $recipientAccount->user_id,
                    'amount' => $amount,
                    'description' => "Transferred to Account {$recipientAccount->account_number}",
                ]);
                
                Transaction::create([
                    'sender_id' => $recipientAccount->user_id,
                    'bank_account_id' => $recipientAccount->id, // recipient's bank account ID
                    'recipient_id' => $sender->id,
                    'amount' => $amount,
                    'description' => "Received from Account {$senderAccount->account_number}",
                ]);
                
        });

        return redirect()->route('transfer.index')->with('success', 'Fund transfer successful!');
    }

    public function history()
    {
        $user = Auth::user(); 
    
        $sentTransactions = Transaction::where('recipient_id', $user->id)->with('sender')->get();
        $receivedTransactions = Transaction::where('sender_id', $user->id)->with('recipient')->get();
    
        return view('user.history', compact('sentTransactions', 'receivedTransactions'));
    }

    public function currency()
    {
        $user = Auth::user(); 
    
        $sentTransactions = Transaction::where('recipient_id', $user->id)->with('sender')->get();
        $receivedTransactions = Transaction::where('sender_id', $user->id)->with('recipient')->get();
    
        return view('user.currency', compact('sentTransactions', 'receivedTransactions'));
    }
    
    public function currency_store(Request $request)
    {
        $user = Auth::user();
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $recipientId = $request->input('account_number');

        $recipient = BankAccount::where('account_number', $recipientId)->first();
        $sender = Transaction::where('recipient_id', $user->id)->with('sender')->first();
 
        $userCurrency = $sender->currency;

        if ($userCurrency !== $currency) {
            $exchangeRate = $this->currencyService->getExchangeRate($userCurrency, $currency);
            if ($exchangeRate) {
                // Apply the 0.01 spread
                $conversionRate = $exchangeRate * 0.99; 
                $convertedAmount = $amount * $conversionRate;
            } else {
                return back()->with('error', 'Unable to fetch exchange rates.');
            }
        } else {
            $convertedAmount = $amount; 
        }

        
        Transaction::create([
            'sender_id' => $user->id,
            'recipient_id' => $recipient->id,
            'amount' => $convertedAmount,
            'currency' => $currency,
            'transaction_type' => 'transfer',  
            'bank_account_id' =>  $sender->bank_account_id,
            'description' => $request->input('description'),
        ]);

        return back()->with('success', 'Transaction completed successfully.');
    }
}
