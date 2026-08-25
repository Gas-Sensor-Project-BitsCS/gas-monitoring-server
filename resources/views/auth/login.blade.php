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
            <input type="text" name="email" id="name" placeholder="Email" maxlength="120" required>
        </div>
        <div class="item">
            <label>Password</label><br>
            <input type="text" name="password" id="name" placeholder="password" minlength="8" required>
        </div>
        
        <button type="submit" class="login-btn btn">Log In</button>
    </form>
    <div class="signup-link">
        <p>Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
    </div>
    @if ($errors->any())
    <div style="color: red; margin-bottom: 1rem;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>

@endsection
