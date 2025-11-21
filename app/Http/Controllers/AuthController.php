<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private function redirectBasedOnRole()
    {
        $user = Auth::user();

        return match ($user->role) {
            'admin' => redirect('admin'),
            'pekebun' => redirect('pekebun'),
            default => redirect('dashboard'),
        };
    }

    public function get_login_page()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        return view('auth.login');
    }

    public function get_register_page()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        return view('auth.register');
    }

    public function logout()
    {
        Auth::logout();
        return redirect(url('/login'))->with([
            'success' => [
                "title" => "Berhasil keluar",
            ]
        ]);
    }
}
