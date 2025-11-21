<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class RegisterForm extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', Password::min(8)],
            'password_confirmation' => 'required_with:password|same:password',
        ];
    }

    protected $messages = [
        'name.required' => 'Nama lengkap wajib diisi',
        'name.min' => 'Nama lengkap minimal 3 karakter',
        'name.max' => 'Nama lengkap maksimal 255 karakter',
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email sudah terdaftar',
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password minimal 8 karakter',
        'password_confirmation.required' => 'Konfirmasi password wajib diisi',
        'password_confirmation.same' => 'Konfirmasi password tidak sama',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function register()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        return redirect(url('/login'))->with([
            'success' => [
                'title' => 'Registrasi berhasil! silahkan masuk.'
            ]
        ]);
    }
}
