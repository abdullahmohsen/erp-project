<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class WelcomeController extends Controller
{
    public function index()
    {
        $users_count = User::whereRoleIs('admin')->count();
        $maincategories_count = Category::parent()->count();
        $subcategories_count = Category::child()->count();
        $products_count = Product::count();

        return view('dashboard.welcome', compact('users_count', 'maincategories_count', 'subcategories_count', 'products_count'));

    }//end of index

}//end of controller
