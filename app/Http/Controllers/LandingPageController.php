<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;

class LandingPageController extends Controller
{
    public function DashboardPage()
    {
        return view('dashboard');
    }

    public function UserPage()
    {
        if(Auth::user()->role == 'Administrator')
        {
            return view('user');
        }
    }

    public function ProductPage()
    {
        return view('product');
    }

    public function CreateProductPage()
    {
        return view('create_product');
    }

    public function CategoryPage()
    {
        return view('category');
    }
    
}
