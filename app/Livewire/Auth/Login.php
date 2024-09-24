<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Sign In')]
class Login extends Component
{
    public $email, $password;

    public function signIn()
    {
        $this->validate([
            'email' => ['required', 'email', 'max:255', 'exists:users,email'],
            'password' => ['required', 'max:255', 'min:6'],
        ]);

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            // session()->flash('error', 'Invalid credentials');
            $this->alert(
                type: 'error',
                message: 'Invalid credentials',
                options: ['position' => 'top-start', 'timer' => 5000]
            );

            return;
        }
        $this->alert(message: 'Logged in successfully!', options: ['position' => 'top-start']);

        return redirect()->to('/');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
