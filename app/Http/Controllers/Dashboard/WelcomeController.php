<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    public function index()
    {
        $users_count = User::whereRoleIs('admin')->count();

        return view('dashboard.welcome', compact('users_count'));

    }//end of index

}//end of controller
