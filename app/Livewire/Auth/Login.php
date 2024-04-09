<?php

namespace App\Livewire\Auth;

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;

    public function render()
    {
        return view('livewire.auth.login');
    }

    public function login()
    {

        $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            return Notification::make()->title('Invalid Credentials')->body('Please check your email or password.')->danger()->send();
        }

        return redirect()->route('home');
    }
}
