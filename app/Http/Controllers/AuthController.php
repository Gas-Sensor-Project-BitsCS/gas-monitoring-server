<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginPage(){
        return view('auth.login');
    }

    // Handle register
    public function register(Request $request){
        $fields = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string']
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
            'role' => 'user'  // Default
        ]);
        Auth::login($user);
        return redirect('dashboard');
       
    }

    // Handle Login
    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','string']
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ])->onlyInput('email');
    }

    // Logout
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('login');
    }


}
