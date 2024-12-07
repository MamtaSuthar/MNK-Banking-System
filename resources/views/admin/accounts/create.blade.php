@extends('layouts.admin')

@section('content')
    <h1>Create New Bank Account</h1>

    <form method="POST" action="{{ route('admin.accounts.store') }}">
        @csrf

        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" name="dob" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">Create Account</button>
    </form>
@endsection
