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
        <label for="name">Name</label><br>
        <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Your Name" maxlength="255" required>
        <span class="error-msg" id="nameError"></span>
        @error('name')
            <span class="server-error">{{ $message }}</span>
        @enderror
    </div>

    <div class="item">
        <label for="email">Email</label><br>
        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email" maxlength="255" required>
        <span class="error-msg" id="emailError"></span>
        @error('email')
            <span class="server-error">{{ $message }}</span>
        @enderror
    </div>

    <div class="item">
        <label for="password">Password</label><br>
        <input type="password" name="password" id="password" placeholder="Password" minlength="8" required>
        <span class="error-msg" id="passwordError"></span>
        @error('password')
            <span class="server-error">{{ $message }}</span>
        @enderror
    </div>

    <div class="item">
        <label for="password_confirmation">Re-enter Password</label><br>
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-enter password" minlength="8" required>
        <span class="error-msg" id="confirmPasswordError"></span>
    </div>
    <button type="submit" class="login-btn btn">Sign up</button>
    </form>
    <div class="signup-link">
        <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
    </div>

</div>

@endsection

@push('scripts')
    <script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
    let isValid = true;

    // Clear previous JS error messages
    document.querySelectorAll('.error-msg').forEach(el => el.textContent = '');

    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    
    // Simple email regex check
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!name) {
        document.getElementById('nameError').textContent = 'Name is required.';
        isValid = false;
    }

    if (!email || !emailRegex.test(email)) {
        document.getElementById('emailError').textContent = 'Please enter a valid email address.';
        isValid = false;
    }

    if (password.length < 8) {
        document.getElementById('passwordError').textContent = 'Password must be at least 8 characters.';
        isValid = false;
    }

    if (password !== confirmPassword) {
        document.getElementById('confirmPasswordError').textContent = 'Passwords do not match.';
        isValid = false;
    }

    // Stop form submission if JS validation fails
    if (!isValid) {
        e.preventDefault();
    }
});
</script>
@endpush