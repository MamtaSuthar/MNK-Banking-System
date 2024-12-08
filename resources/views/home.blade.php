@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>Welcome, {{ $user->first_name }}  {{ $user->last_name }}!</h4>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Account Number:</strong> 
                        {{ $user->bankAccounts->isNotEmpty() ? $user->bankAccounts[0]->account_number : 'N/A' }}
                    </p>
                    <p><strong>Balance:</strong> 
                        ${{ $user->bankAccounts->isNotEmpty() ? number_format($user->bankAccounts[0]->balance, 2) : '0.00' }}
                    </p>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
