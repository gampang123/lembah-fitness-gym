<link rel="stylesheet" href="{{ asset('common/css/login.css') }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://unpkg.com/feather-icons"></script>


<div class="login-container">
    <div style="display: flex; justify-content: center; align-items: center;">
        <img style="width: 50px;" src="{{ asset('asset/logo-circle.svg') }}" alt="">
    </div>
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
        <div class="input-group password-group" style="position: relative;">
            <label>
                <span class="input-icon">
                    <i data-feather="lock"></i>
                </span>
                <input id="password" class="input-field" type="password" name="password" placeholder="Password"
                    required autocomplete="current-password" />
            </label>

            <!-- Toggle Password Icon -->
            <i id="togglePasswordIcon" data-feather="eye"
                style="position: absolute; top: 12px; right: 12px; cursor: pointer; color:rgb(87, 87, 87);"
                onclick="togglePassword()"></i>

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


<script>
    function togglePassword() {
        const passwordField = document.getElementById("password");
        const toggleIcon = document.getElementById("togglePasswordIcon");

        const isHidden = passwordField.type === "password";
        passwordField.type = isHidden ? "text" : "password";

        toggleIcon.setAttribute("data-feather", isHidden ? "eye-off" : "eye");
        feather.replace();
    }
</script>
<script>
    feather.replace();
</script>
