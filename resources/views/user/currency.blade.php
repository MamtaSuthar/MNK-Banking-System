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

    <form method="POST" action="{{ route('currency.store') }}">
        @csrf
        <div class="form-group">
            <label for="recipient_id">Recipient</label>
            <input type="text" class="form-control" name="recipient_id" required>
        </div>

        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" class="form-control" name="amount" required>
        </div>

        <div class="form-group">
            <label for="currency">Currency</label>
            <select name="currency" class="form-control" required>
                <option value="USD">USD</option>
                <option value="GBP">GBP</option>
                <option value="EUR">EUR</option>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Transfer</button>
    </form>

@endsection