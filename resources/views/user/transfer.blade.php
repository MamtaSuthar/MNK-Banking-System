@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Fund Transfer</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('transfer.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="recipient_account_number" class="form-label">Recipient Account Number</label>
            <input type="text" id="recipient_account_number" name="recipient_account_number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" id="amount" name="amount" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Transfer</button>
    </form>
</div>
@endsection
