<?php
namespace App\Http\Controllers;

use App\BankAccount;
use App\Transaction;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    public function index(Request $request)
    {
        $query = BankAccount::with('user')->latest();

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->whereHas('user', function($q) use ($request) {
                    $q->where('first_name', 'like', '%'.$request->search.'%')
                      ->orWhere('last_name', 'like', '%'.$request->search.'%');
                })
                ->orWhere('account_number', 'like', '%'.$request->search.'%')
                ->orWhere('balance', 'like', '%'.$request->search.'%');
            });
        }

        $accounts = $query->get();

        return view('admin.accounts.index', compact('accounts'));
    }

    public function showTransactions($accountId)
    {
        $account = BankAccount::with('transactions')->findOrFail($accountId);
        return view('admin.accounts.transactions', compact('account'));
    }

    public function addTransaction(Request $request, $accountId)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'transaction_type' => 'required|in:debit,credit',
            'description' => 'required|string',
        ]);

        $account = BankAccount::findOrFail($accountId);

        if ($request->transaction_type == 'debit') {
            $account->balance -= $request->amount;
        } else {
            $account->balance += $request->amount;
        }

        $account->save();

        Transaction::create([
            'account_id' => $account->id,
            'amount' => $request->amount,
            'transaction_type' => $request->transaction_type,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.accounts.showTransactions', $accountId)->with('success', 'Transaction completed successfully');
    }
}
