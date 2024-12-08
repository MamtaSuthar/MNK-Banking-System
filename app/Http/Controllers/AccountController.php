<?php
namespace App\Http\Controllers;

use App\BankAccount;
use App\Transaction;
use Illuminate\Http\Request;
use App\User;

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

    public function openMultipleAccounts(Request $request)
    {
        $accounts = $request->input('accounts');
        foreach ($accounts as $account) {
            $user = User::create([
                'first_name' => $account['first_name'],
                'last_name'  => $account['last_name'],
                'dob'        => $account['dob'],
                'address'    => $account['address'],
                'email'      => $account['email'], 
                'password'   => bcrypt('defaultpassword'), 
            ]);

            BankAccount::create([
                'user_id'        => $user->id,
                'account_number' => $this->generateUniqueAccountNumber(),
                'balance'        => 10000,
                'account_type'   => 'savings',
                'is_active'      => true,
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Saving accounts created successfully.');
    }

    private function generateUniqueAccountNumber()
    {
        do {
            $accountNumber = mt_rand(1000000000, 9999999999); // 10-digit account number
        } while (BankAccount::where('account_number', $accountNumber)->exists());

        return $accountNumber;
    }
}
