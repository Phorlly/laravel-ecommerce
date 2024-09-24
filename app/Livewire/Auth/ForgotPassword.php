<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Forgot Password')]
class ForgotPassword extends Component
{
    public $email;

    public function resetPassword()
    {
        $this->validate([
            'email' => 'required|email|exists:users',
        ]);

        // Send password reset link to user's email
        $status = Password::sendResetLink(['email' => $this->email]);
        if ($status === Password::RESET_LINK_SENT) {
            // Flash a success message
            session()->flash('success', 'Password reset link sent to your email!');
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
