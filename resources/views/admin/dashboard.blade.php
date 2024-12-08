@extends('layouts.admin')

<style>
.account-form {
    border: 1px solid #ddd;
    padding: 15px;
    margin-bottom: 15px;
}

.form-row {
    display: flex;
    gap: 15px;
    align-items: flex-start;
}

.form-group {
    flex: 1;
    min-width: 150px;
}

textarea.form-control {
    height: 38px; 
    resize: none; 
}
</style>

@section('content')
    <h1>Open Saving Accounts for Users</h1>

    <form action="{{ route('admin.accounts.openMultiple') }}" method="POST">
        @csrf
        <div id="accounts-form-container" class="linear-form">
            <div class="account-form">
                <h3>Account 1</h3>
                <div class="form-row">
                    <div class="form-group col-md-1">
                        <label for="first_name">First Name</label>
                        <input type="text" name="accounts[0][first_name]" class="form-control" required>
                    </div>
                    <div class="form-group col-md-1">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="accounts[0][last_name]" class="form-control" required>
                    </div>
                    <div class="form-group col-md-1">
                        <label for="email">Email</label>
                        <input type="email" name="accounts[0][email]" class="form-control" required>
                    </div>
                    <div class="form-group col-md-1">
                        <label for="dob">Date of Birth</label>
                        <input type="date" name="accounts[0][dob]" class="form-control" required>
                    </div>
                    <div class="form-group col-md-1">
                        <label for="address">Address</label>
                        <textarea name="accounts[0][address]" class="form-control" required></textarea>
                    </div>
                </div>
                <button type="button" class="btn btn-danger remove-account mt-2" style="display: none;">Remove</button>
            </div>            
        </div>

        <button type="button" id="add-account" class="btn btn-info mt-3">Add Another Account</button>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
@endsection

@section('custome-script')
    <script>
        let accountIndex = 1;
        $('#add-account').click(function () {
          
            const newAccountForm = `
                <div class="account-form">
                    <h3>Account ${accountIndex + 1}</h3>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="first_name">First Name</label>
                            <input type="text" name="accounts[${accountIndex}][first_name]" class="form-control" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="accounts[${accountIndex}][last_name]" class="form-control" required>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="email">Email</label>
                            <input type="email" name="accounts[${accountIndex}][email]" class="form-control" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="dob">Date of Birth</label>
                            <input type="date" name="accounts[${accountIndex}][dob]" class="form-control" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="address">Address</label>
                            <textarea name="accounts[${accountIndex}][address]" class="form-control" required></textarea>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger remove-account mt-2">Remove</button>
                </div>
            `;
            $('#accounts-form-container').append(newAccountForm);
            accountIndex++;
        });

        // Remove an account form
        $(document).on('click', '.remove-account', function () {
            $(this).closest('.account-form').remove();
        });
    </script>
@endsection
