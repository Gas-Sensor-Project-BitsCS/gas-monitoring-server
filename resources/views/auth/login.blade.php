@extends('auth.auth')
@section('form')
<div class="form-box">
    <div class="login-header">
        <h2>Welcome Back</h2>
        <p>Sign in to your account</p>
    </div>
    <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="item">
            <label>Email</label><br>
            <input type="email" name="email" id="email" placeholder="Email" maxlength="255" required>
            @error('email')
            <span class="server-error">{{ $message }}</span>
            @enderror
        </div>
        <div class="item">
            <label>Password</label><br>
            <input type="password" name="password" id="password" placeholder="password" minlength="8" required>
        </div>
        
        <button type="submit" class="login-btn btn">Log In</button>
    </form>
    <div class="signup-link">
        <p>Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
    </div>
    
</div>

@endsection
