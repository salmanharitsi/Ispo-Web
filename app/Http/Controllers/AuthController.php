<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function get_login_page()
    {
        if (!empty(Auth::check())) {
            return redirect('dashboard');
        }
        return view('auth.login');
    }
}
