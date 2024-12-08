@extends('layouts.admin')

@section('content')
{{-- @dd($account) --}}
    <h1>Transactions for Account: {{ $account->account_number }}</h1>

    <div class="card mt-3">
        <div class="card-header">
            <h4>Account Details</h4>
        </div>
        <div class="card-body">
            <p><strong>First Name:</strong> {{ $account['user']['first_name'] }}</p>
            <p><strong>Last Name:</strong> {{ $account['user']['last_name'] }}</p>
            <p><strong>Date of Birth:</strong> {{ $account['user']['dob'] }}</p>
            <p><strong>Address:</strong> {{ $account['user']['address'] }}</p>
            
            <p><strong>Account Type:</strong> {{ $account->account_type }}</p>
            <p><strong>Balance:</strong> ${{ $account->balance }}</p>
        </div>
    </div>

    <div class="mt-4">
        <h2>Transactions</h2>

        @if($account->transactions->isEmpty())
            <p>No transactions found for this account.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($account['transactions'] as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                            <td>{{ $transaction->amount }}</td>
                            <td>{{ ucfirst($transaction->type) }}</td>
                            <td>{{ $transaction->description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
