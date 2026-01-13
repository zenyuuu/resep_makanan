<x-guest-layout>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    <div class="auth-wrapper">
        <div class="auth-container">
            <div class="auth-card">
                <!-- Header -->
                <div class="auth-header">
                    <div class="auth-brand">
                        <i class="fas fa-utensils"></i>
                        <span>MauMasakApa</span>
                    </div>
                    <h1>Login</h1>
                    <p>Selamat datang kembali, Chef! 👨‍🍳</p>
                </div>

                <!-- Body -->
                <div class="auth-body">
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="auth-status">
                            <i class="fas fa-check-circle"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="auth-form-group">
                            <label for="email">
                                <i class="fas fa-envelope"></i> Email
                            </label>
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Masukkan email Anda"
                                   required 
                                   autofocus 
                                   autocomplete="username" />
                            @error('email')
                                <div class="auth-error">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="auth-form-group">
                            <label for="password">
                                <i class="fas fa-lock"></i> Password
                            </label>
                            <input id="password" 
                                   type="password" 
                                   name="password" 
                                   placeholder="Masukkan password Anda"
                                   required 
                                   autocomplete="current-password" />
                            @error('password')
                                <div class="auth-error">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="auth-checkbox-group">
                            <div class="auth-checkbox">
                                <input id="remember_me" 
                                       type="checkbox" 
                                       name="remember">
                                <label for="remember_me">
                                    <i class="fas fa-check"></i> Ingat saya
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="auth-forgot-link">
                                    <i class="fas fa-key"></i> Lupa password?
                                </a>
                            @endif
                        </div>

                        <!-- Button -->
                        <button type="submit" class="auth-btn auth-btn-primary auth-btn-full">
                            <i class="fas fa-sign-in-alt"></i> Login Sekarang
                        </button>

                        <!-- Register Link -->
                        <div class="auth-footer">
                            <p style="display: flex; align-items: center; justify-content: center; gap: 6px; flex-wrap: wrap;">
                                <span>Belum punya akun?</span>
                                <a href="{{ route('register') }}" class="auth-link">
                                    <i class="fas fa-user-plus"></i> Daftar sekarang
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
