@extends('layouts.admin')

@section('content')
    <h1>Open Saving Accounts for Users</h1>

    <form action="{{ route('admin.accounts.openMultiple') }}" method="POST">
        @csrf
        <div id="accounts-form-container">
            <div class="account-form">
                <h3>Account 1</h3>
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="accounts[0][first_name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="accounts[0][last_name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" name="accounts[0][dob]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea name="accounts[0][address]" class="form-control" required></textarea>
                </div>
            </div>
        </div>

        <button type="button" id="add-account" class="btn btn-info">Add Another Account</button>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        let accountIndex = 1;

        document.getElementById('add-account').addEventListener('click', function() {
            const container = document.getElementById('accounts-form-container');
            const newAccountForm = document.createElement('div');
            newAccountForm.classList.add('account-form');
            newAccountForm.innerHTML = `
                <h3>Account ${accountIndex + 1}</h3>
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="accounts[${accountIndex}][first_name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="accounts[${accountIndex}][last_name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" name="accounts[${accountIndex}][dob]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea name="accounts[${accountIndex}][address]" class="form-control" required></textarea>
                </div>
            `;
            container.appendChild(newAccountForm);
            accountIndex++;
        });
    </script>
@endsection
