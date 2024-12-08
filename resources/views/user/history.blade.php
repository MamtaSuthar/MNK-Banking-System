@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Transaction History</h1>

    <h2>Outgoing Transactions</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Receiver</th>
                <th>Amount</th>
                <th>Currency</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sentTransactions as $transaction)
                <tr>
                    <td>{{ $transaction['sender']->first_name }}{{ $transaction['sender']->last_name }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ $transaction->currency }}</td>
                    <td>{{ $transaction->transaction_date}}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No outgoing transactions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h2>Incoming Transactions</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Sender</th>
                <th>Amount</th>
                <th>Currency</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($receivedTransactions as $transaction)
                <tr>
                    <td>{{ $transaction['recipient']->first_name }}{{ $transaction['recipient']->last_name }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ $transaction->currency }}</td>
                    <td>{{ $transaction->transaction_date}}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No incoming transactions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
