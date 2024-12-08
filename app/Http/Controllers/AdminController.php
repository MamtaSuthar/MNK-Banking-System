<?php

namespace App\Http\Controllers;

use App\User;
use App\BankAccount;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    public function index()
    {
        $users = User::where('is_admin', 0)->with('bankAccounts')->get();  
        return view('admin.dashboard', compact('users'));
    }

    public function manageUsers(Request $request)
    {
        $query = User::where('is_admin', 0)->with('bankAccounts');
    
        if ($request->has('search_first_name') && !empty($request->input('search_first_name'))) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->input('search_first_name') . '%');
            });
        }
    
        if ($request->has('search_last_name') && !empty($request->input('search_last_name'))) {
            $query->where(function ($q) use ($request) {
                $q->where('last_name', 'like', '%' . $request->input('search_last_name') . '%');
            });
        }

        if ($request->has('search_email') && !empty($request->input('search_email'))) {
            $query->where(function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->input('search_email') . '%');
            });
        }

        if ($request->has('search_dob') && !empty($request->input('search_dob'))) {
            $query->where(function ($q) use ($request) {
                $q->where('dob', 'like', '%' . $request->input('search_dob') . '%');
            });
        }

        $users = $query->get();
    
        return view('admin.users.index', compact('users'));
    }
    
    
}
