@extends('auth.auth')
@section('form')
<div class="form-box">
    <div class="login-header">
        <h2>Sign-up</h2>
        <p>Create your new account</p>
    </div>
    <form action="{{ route('register') }}" method="post">
        @csrf
        <div class="item">
            <label>Name</label><br>
            <input type="text" name="name" id="name" placeholder="Your Name" maxlength="120" required>
        </div>
        <div class="item">
            <label>Email</label><br>
            <input type="text" name="email" id="name" placeholder="Email" maxlength="120" required>
        </div>
        <div class="item">
            <label>Password</label><br>
            <input type="text" name="password" id="name" placeholder="password" minlength="8" required>
        </div>
        <div class="item">
            <label>Re-enter Password</label><br>
            <input type="text" name="" id="name" placeholder="re-enter password" minlength="8" required>
        </div>
        <button type="submit" class="login-btn btn">Submit</button>
    </form>
    <div class="signup-link">
        <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
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
