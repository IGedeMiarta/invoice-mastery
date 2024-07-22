<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormLogin extends Component
{
    public $email,$password,$remember;
    protected $rules = [
        'email' => 'required|email',
        'password'=>'required'
    ];
    public function save(){
        $this->validate();
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            // Authentication passed
            session()->flash('message', 'Login successful.');
            return redirect()->intended('/dashboard');
        } else {
            // Authentication failed
            session()->flash('error', 'The provided credentials do not match our records.');
        }
    }
    public function render()
    {
        return view('livewire.auth.form-login');
    }
}
