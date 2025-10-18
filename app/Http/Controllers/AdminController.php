<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }


    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}
