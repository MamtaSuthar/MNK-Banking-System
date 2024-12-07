<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function manageUsers()
    {
        $users = User::where('is_admin',0)->get();  
        return view('admin.users.index', compact('users'));
    }
}
