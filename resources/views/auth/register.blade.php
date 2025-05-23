<link rel="stylesheet" href="{{ asset('common/css/login.css') }}">

<div class="login-container">
    <h2>Buat <span class="highlight">Akun</span></h2>
    <p style="text-align: center;">Selamat Bergabung Di</p>
    <h2>Lembah Fitness Warungboto</span></h2>

    <form method="POST" action="{{ route('register') }}" class="login-form">
        @csrf

        <!-- Name -->
        <div class="input-group">
            <label>
                <span class="input-icon">🧑</span>
                <input id="name" class="input-field" type="text" name="name" :value="old('name')"
                    placeholder="Full Name" required autofocus autocomplete="name" />
            </label>
            <x-input-error :messages="$errors->get('name')" class="input-error" />
        </div>

        <!-- Username -->
        <div class="input-group">
            <label>
                <span class="input-icon">👤</span>
                <input id="username" class="input-field" type="text" name="username" :value="old('username')"
                    placeholder="Username" required autocomplete="username" />
            </label>
            <x-input-error :messages="$errors->get('username')" class="input-error" />
        </div>

        <!-- Phone -->
        <div class="input-group">
            <label>
                <span class="input-icon">📞</span>
                <input id="phone" class="input-field" type="text" name="phone" :value="old('phone')"
                    placeholder="Phone Number" required />
            </label>
            <x-input-error :messages="$errors->get('phone')" class="input-error" />
        </div>

        <!-- Email -->
        <div class="input-group">
            <label>
                <span class="input-icon">📧</span>
                <input id="email" class="input-field" type="email" name="email" :value="old('email')"
                    placeholder="Email Address" required autocomplete="email" />
            </label>
            <x-input-error :messages="$errors->get('email')" class="input-error" />
        </div>

        <!-- Password -->
        <div class="input-group">
            <label>
                <span class="input-icon">🔒</span>
                <input id="password" class="input-field" type="password" name="password" placeholder="Password"
                    required autocomplete="new-password" />
            </label>
            <x-input-error :messages="$errors->get('password')" class="input-error" />
        </div>

        <!-- Confirm Password -->
        <div class="input-group">
            <label>
                <span class="input-icon">🔒</span>
                <input id="password_confirmation" class="input-field" type="password" name="password_confirmation"
                    placeholder="Confirm Password" required autocomplete="new-password" />
            </label>
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
