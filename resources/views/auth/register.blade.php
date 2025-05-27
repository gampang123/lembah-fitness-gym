<link rel="stylesheet" href="{{ asset('common/css/login.css') }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://unpkg.com/feather-icons"></script>



<div class="login-container">
    <div style="display: flex; justify-content: center; align-items: center;">
        <img style="width: 50px;" src="{{ asset('asset/logo-circle.svg') }}" alt="">
    </div>
    <h2>Buat <span class="highlight">Akun</span></h2>
    <p style="text-align: center;">Selamat Bergabung Di</p>
    <h2>Lembah Fitness Warungboto</h2>

    <form method="POST" action="{{ route('register') }}" class="login-form">
        @csrf

        <!-- Name -->
        <div class="input-group">
            <label>
                <span class="input-icon"><i data-feather="user"></i></span>
                <input id="name" class="input-field" type="text" name="name" :value="old('name')"
                    placeholder="Full Name" required autofocus autocomplete="name" />
            </label>
            <x-input-error :messages="$errors->get('name')" class="input-error" />
        </div>

        <!-- Username -->
        <div class="input-group">
            <label>
                <span class="input-icon"><i data-feather="user-check"></i></span>
                <input id="username" class="input-field" type="text" name="username" :value="old('username')"
                    placeholder="Username" required autocomplete="username" />
            </label>
            <x-input-error :messages="$errors->get('username')" class="input-error" />
        </div>

        <!-- Phone -->
        <div class="input-group">
            <label>
                <span class="input-icon"><i data-feather="phone"></i></span>
                <input id="phone" class="input-field" type="text" name="phone" :value="old('phone')"
                    placeholder="Phone Number" required />
            </label>
            <x-input-error :messages="$errors->get('phone')" class="input-error" />
        </div>

        <!-- Email -->
        <div class="input-group">
            <label>
                <span class="input-icon"><i data-feather="mail"></i></span>
                <input id="email" class="input-field" type="email" name="email" :value="old('email')"
                    placeholder="Email Address" required autocomplete="email" />
            </label>
            <x-input-error :messages="$errors->get('email')" class="input-error" />
        </div>

        <!-- Password -->
        <div class="input-group" style="position: relative;">
            <label>
                <span class="input-icon"><i data-feather="lock"></i></span>
                <input id="password" class="input-field" type="password" name="password" placeholder="Password"
                    required autocomplete="new-password" />
            </label>
            <i id="togglePassword" data-feather="eye"
                style="position: absolute; top: 12px; right: 12px; cursor: pointer; color:rgb(87, 87, 87);"
                onclick="togglePassword('password', 'togglePassword')"></i>
            <x-input-error :messages="$errors->get('password')" class="input-error" />
        </div>

        <!-- Confirm Password -->
        <div class="input-group" style="position: relative;">
            <label>
                <span class="input-icon"><i data-feather="lock"></i></span>
                <input id="password_confirmation" class="input-field" type="password" name="password_confirmation"
                    placeholder="Confirm Password" required autocomplete="new-password" />
            </label>
            <i id="toggleConfirmPassword" data-feather="eye"
                style="position: absolute; top: 12px; right: 12px; cursor: pointer; color:rgb(87, 87, 87);"
                onclick="togglePassword('password_confirmation', 'toggleConfirmPassword')"></i>
            <x-input-error :messages="$errors->get('password_confirmation')" class="input-error" />
        </div>

        <!-- Submit -->
        <button type="submit" class="login-button">REGISTER</button>

        <!-- Already Registered -->
        <div class="forgot" style="font-size: 12px; text-align: center; margin-top: 10px;">
            Already registered?
            <a href="{{ route('login') }}">Login here</a>
        </div>
    </form>
</div>


<script>
    feather.replace();

    function togglePassword(id, iconId) {
        const passwordField = document.getElementById(id);
        const icon = document.getElementById(iconId);

        const isHidden = passwordField.type === "password";
        passwordField.type = isHidden ? "text" : "password";

        icon.setAttribute("data-feather", isHidden ? "eye-off" : "eye");
        feather.replace();
    }
</script>
