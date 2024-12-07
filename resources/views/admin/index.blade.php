@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bank Accounts</h1>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Account Number</th>
                <th>Account Type</th>
                <th>Balance</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accounts as $account)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $account->account_number }}</td>
                    <td>{{ $account->account_type }}</td>
                    <td>${{ $account->balance }}</td>
                    <td>{{ $account->user->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
