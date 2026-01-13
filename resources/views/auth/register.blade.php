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
                    <h1>Daftar</h1>
                    <p>Bergabung dengan komunitas kami sekarang!</p>
                </div>

                <!-- Body -->
                <div class="auth-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="auth-form-group">
                            <label for="name">Nama Lengkap</label>
                            <input id="name" 
                                   type="text" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Masukkan nama Anda"
                                   required 
                                   autofocus 
                                   autocomplete="name" />
                            @error('name')
                                <div class="auth-error">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="auth-form-group">
                            <label for="email">Email</label>
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Masukkan email Anda"
                                   required 
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
                            <label for="password">Password</label>
                            <input id="password" 
                                   type="password" 
                                   name="password" 
                                   placeholder="Minimal 8 karakter"
                                   required 
                                   autocomplete="new-password" />
                            @error('password')
                                <div class="auth-error">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="auth-form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input id="password_confirmation" 
                                   type="password" 
                                   name="password_confirmation" 
                                   placeholder="Ulangi password Anda"
                                   required 
                                   autocomplete="new-password" />
                            @error('password_confirmation')
                                <div class="auth-error">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Button -->
                        <div class="auth-btn-group">
                            <button type="submit" class="auth-btn auth-btn-primary">
                                <i class="fas fa-user-plus"></i> Daftar
                            </button>
                        </div>

                        <!-- Link to Login -->
                        <div class="auth-footer">
                            <p style="display: flex; align-items: center; justify-content: center; gap: 6px; flex-wrap: wrap;">
                                <span>Sudah punya akun?</span>
                                <a href="{{ route('login') }}" class="auth-link">
                                    <i class="fas fa-sign-in-alt"></i> Login di sini
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
