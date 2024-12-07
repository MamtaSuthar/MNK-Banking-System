@extends('layouts.admin')

@section('content')
    <h1>Transaction History for Account: {{ $account->account_number }}</h1>

    <form method="POST" action="{{ route('admin.accounts.addTransaction', $account->id) }}" class="mb-3">
        @csrf
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" name="amount" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="transaction_type">Transaction Type</label>
            <select name="transaction_type" class="form-control" required>
                <option value="credit">Credit</option>
                <option value="debit">Debit</option>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">Add Transaction</button>
    </form>

    <h3>Transaction History</h3>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Amount</th>
                <th>Transaction Type</th>
                <th>Description</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($account->transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->amount }} {{ $account->currency }}</td>
                    <td>{{ ucfirst($transaction->transaction_type) }}</td>
                    <td>{{ $transaction->description }}</td>
                    <td>{{ $transaction->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
