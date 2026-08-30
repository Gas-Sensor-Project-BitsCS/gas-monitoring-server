<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // show Login Page
    public function showLoginPage(){
        return view('auth.login');
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(Request $request)
    {
        // 1. Validate the incoming request data
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required', 
                'string', 
                'min: 8',
                'max: 120',
                'confirmed', // Expects a matching 'password_confirmation' field
                Password::defaults() // Applies standard Laravel security rules
            ],
        ]);

        // 2. Create the user record in the database
        $user = User::create([
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
        ]);

        // 3. Log the newly registered user in automatically
        Auth::login($user);

        // 4. Regenerate session to prevent session fixation attacks
        $request->session()->regenerate();

        // 5. Redirect to intended page or dashboard with success message
        return redirect()->intended('/dashboard')
            ->with('success', 'Account created successfully!');
    }

    /** 
     * Handle Login request
     */
    public function login(Request $request)
    {
        // 1. Validate incoming input
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 2. Normalize email to lowercase (matches registration normalization)
        $credentials['email'] = strtolower($credentials['email']);

        // 3. Attempt authentication (Finds user by email + verifies hashed password)
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Prevent session fixation attacks
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        // 4. Return failure response if lookup or password check fails
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Handle Logout
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('login');
    }


}
