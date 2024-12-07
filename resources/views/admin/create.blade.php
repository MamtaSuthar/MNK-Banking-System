@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Bank Account</h1>
    <form method="POST" action="{{ route('accounts.store') }}">
        @csrf
        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select class="form-control" id="user_id" name="user_id">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="account_type" class="form-label">Account Type</label>
            <select class="form-control" id="account_type" name="account_type">
                <option value="savings">Savings</option>
                <option value="current">Current</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Account</button>
    </form>
</div>
@endsection
