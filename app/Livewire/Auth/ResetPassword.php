<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Password;

#[Title('Reset Password')]
class ResetPassword extends Component
{
    #[Url]
    public $email;
    public $token, $password, $password_confirmation;

    public function mount($token)
    {
        $this->token = $token;
    }

    public function modify()
    {
        $this->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6|max:255',
            // 'password_confirmation' => 'required',
        ]);

        $status = Password::reset([
            'token' => $this->token,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation
        ], function (User $user, string $password) {
            $password = $this->password;
            $user->forceFill([
                'password' => bcrypt($password)
            ])->setRememberToken(Str::random(60));
            $user->save();
            event(new PasswordReset($user));
        });

        return $status === Password::PASSWORD_RESET
            ? $this->redirect('/login')
            : session()->flash('error', 'Something went wrong');
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
