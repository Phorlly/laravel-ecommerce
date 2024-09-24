<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Sign Up')]
class Logup extends Component
{
    public $name, $email, $password;

    public function signUp()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'max:255'],
        ]);

        // Create user in database
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        // Log the user in
        Auth::login($user);

        $this->alert(message: 'Created and Logged in!', options: ['position' => 'top-start']);

        // Redirect to home page
        return redirect()->to('/');
    }
    public function render()
    {
        return view('livewire.auth.logup');
    }
}
