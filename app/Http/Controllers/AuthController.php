<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(){
        $data['title'] = 'Login';
        return view('pages.auth.login',$data);
    }
    public function logout(){
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login')->with('message', 'You have been logged out.');
    }
}
