<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginForm extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password minimal 6 karakter',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function login()
    {
        $this->validate();

        if (!Auth::attempt(
            ['email' => $this->email, 'password' => $this->password],
            $this->remember
        )) {
            return redirect(url('/login'))->with([
                'error' => [
                    'title' => 'Email atau password salah.',
                ],
            ]);
        }

        $user = Auth::user();

        return match ($user->role) {
            'pekebun' => redirect(url('/pekebun'))->with([
                'success' => [
                    'title' => 'Berhasil masuk sebagai Pekebun.',
                ],
            ]),
            'admin' => redirect(url('/admin'))->with([
                'success' => [
                    'title' => 'Berhasil masuk sebagai Admin.',
                ],
            ]),
            default => redirect('/'),
        };
    }
}
