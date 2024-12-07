<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        return view('admin.transactions.index', compact('transactions'));
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'sender_account_number' => 'required|string',
            'receiver_account_number' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);

        $sender = BankAccount::where('account_number', $request->sender_account_number)->first();
        $receiver = BankAccount::where('account_number', $request->receiver_account_number)->first();

        if (!$sender || !$receiver) {
            return redirect()->back()->with('error', 'Invalid account number');
        }

        if ($sender->balance < $request->amount) {
            return redirect()->back()->with('error', 'Insufficient funds');
        }

        $sender->balance -= $request->amount;
        $receiver->balance += $request->amount;

        Transaction::create([
            'sender_account_id' => $sender->id,
            'receiver_account_id' => $receiver->id,
            'amount' => $request->amount,
            'currency' => 'USD',
            'type' => 'debit',
            'description' => 'Fund Transfer to ' . $receiver->account_number,
        ]);

        Transaction::create([
            'sender_account_id' => $sender->id,
            'receiver_account_id' => $receiver->id,
            'amount' => $request->amount,
            'currency' => 'USD',
            'type' => 'credit',
            'description' => 'Fund Transfer from ' . $sender->account_number,
        ]);

        $sender->save();
        $receiver->save();

        return redirect()->back()->with('success', 'Fund transfer successful');
    }
}
