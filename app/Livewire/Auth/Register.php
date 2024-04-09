<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    public function render()
    {
        return view('livewire.auth.register');
    }

    public function register()
    {

        $data = $this->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            return Notification::make()->title('Invalid Credentials')->body('Please check your email or password.')->danger()->send();
        }

        return redirect()->route('home');
    }
}
