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

    public function manageUsers()
    {
        $users = User::where('is_admin',0)->get();  
        return view('admin.users.index', compact('users'));
    }
    
}
