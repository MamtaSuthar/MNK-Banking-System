@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Manage User Accounts
                    </div>

                    <div class="card-body">
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('admin.users') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" name="search_first_name" class="form-control" placeholder="Search by First Name" value="{{ request()->input('search_first_name') }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="search_last_name" class="form-control" placeholder="Search by Last Name" value="{{ request()->input('search_last_name') }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="search_email" class="form-control" placeholder="Search by Email" value="{{ request()->input('search_email') }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="date"  id="dob" name="search_dob" class="form-control dob" placeholder="Search by Dob" value="{{ request()->input('search_dob') }}">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-info">Search</button>
                                </div>
                            </div>
                        </form>

                        <!-- Table to List Accounts -->
                        <table class="table mt-3">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>DOB</th>
                                    <th>Address</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->dob }}</td>
                                        <td>{{ $user->address }}</td>                                  
                                        <td>
                                            <a href="#" class="btn btn-primary">Edit</a>
                                            <a href="#" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if($users->isEmpty())
                            <p>No accounts found matching your search criteria.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
