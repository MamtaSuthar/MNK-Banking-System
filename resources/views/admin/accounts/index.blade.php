@extends('layouts.admin')

@section('content')
    <h1>Manage Bank Accounts</h1>

    <form method="GET" action="{{ route('admin.accounts') }}" class="mb-3">
        <input type="text" name="search" placeholder="Search by name, account number or balance" class="form-control" value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary mt-2">Search</button>
    </form>

    <a href="{{ route('admin.accounts.create') }}" class="btn btn-primary mb-3">Create New Account</a>
        <div class="card-body">

            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Account Number</th>
                        <th>User Name</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accounts as $account)
                        <tr>
                            <td>{{ $account->id }}</td>
                            <td>{{ $account->account_number }}</td>
                            <td>{{ $account->user->first_name }} {{ $account->user->last_name }}</td>
                            <td>${{ $account->balance }} {{ $account->currency }}</td>
                            <td>{{ ($account->is_active)==1?'Active':'In Active' }}</td>
                            <td>
                                <a href="{{ route('admin.accounts.showTransactions', $account->id) }}" class="btn btn-info">View Transactions</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
@endsection
