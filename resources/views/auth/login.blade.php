<link rel="stylesheet" href="{{ asset('common/css/login.css') }}">

<div class="login-container">
    <h2>Welcome <span class="highlight">Back!</span></h2>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="login-form">
        @csrf

        <!-- Email Address -->
        <div class="input-group">
            <label>
                <span class="input-icon"><img style="width: 17px;" src="{{ asset('asset/profile.svg') }}"
                        alt=""></span>
                <input id="email" class="input-field" type="email" name="email" :value="old('email')"
                    placeholder="Email Address" required autofocus autocomplete="username" />
            </label>
            <x-input-error :messages="$errors->get('email')" class="input-error" />
        </div>

        <!-- Password -->
        <div class="input-group">
            <label>
                <span class="input-icon">🔒</span>
                <input id="password" class="input-field" type="password" name="password" placeholder="Password"
                    required autocomplete="current-password" />
            </label>
            <x-input-error :messages="$errors->get('password')" class="input-error" />
        </div>

        <!-- Remember Me -->
        <div class="remember-me">
            <input id="remember_me" type="checkbox" name="remember">
            <label for="remember_me">Remember me</label>
        </div>

        <!-- Submit -->
        <button type="submit" class="login-button">LOG IN</button>

        <!-- Forgot Password -->
        @if (Route::has('password.request'))
            <div class="forgot">
                <a href="{{ route('password.request') }}">Forgot Password?</a>
            </div>
        @endif

        <!-- Signup -->
        <div class="signup">
            Don’t have an account?
            <a href="{{ route('register') }}">Sign up</a>
        </div>
    </form>
</div>
