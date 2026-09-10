<x-guest-layout>
    <div class="auth-page-wrapper">
        <!-- Animated background orbs -->
        <div class="auth-bg-orb auth-bg-orb-1"></div>
        <div class="auth-bg-orb auth-bg-orb-2"></div>
        <div class="auth-bg-orb auth-bg-orb-3"></div>

        <div class="auth-container animate-fade-in-up">
            <!-- Logo & Heading -->
            <div class="auth-header">
                <div class="auth-logo-ring">
                    <svg class="auth-logo-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="auth-title">Welcome back</h1>
                <p class="auth-subtitle">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="auth-link">Sign up for free</a>
                </p>
            </div>

            <x-validation-errors class="mb-4" />

            @session('status')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ $value }}
                </div>
            @endsession

            <!-- Glass Card -->
            <div class="auth-glass-card animate-fade-in-up" style="animation-delay: 0.15s;">
                <form class="auth-form" action="{{ route('login') }}" method="POST">
                    @csrf

                    <!-- Email Field -->
                    <div class="auth-field-group">
                        <label for="email" class="auth-label">Email address</label>
                        <div class="auth-input-wrapper">
                            <div class="auth-input-icon">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required autofocus
                                value="{{ old('email') }}"
                                placeholder="you@example.com"
                                class="auth-input @error('email') auth-input-error @enderror">
                        </div>
                        @error('email')
                            <p class="auth-error-msg">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="auth-field-group">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                            <label for="password" class="auth-label" style="margin-bottom:0;">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="auth-forgot-link">Forgot password?</a>
                            @endif
                        </div>
                        <div class="auth-input-wrapper">
                            <div class="auth-input-icon">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                placeholder="••••••••"
                                class="auth-input @error('password') auth-input-error @enderror">
                        </div>
                        @error('password')
                            <p class="auth-error-msg">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-2">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" class="border-gray-300 dark:border-gray-600 rounded text-primary-600 shadow-sm focus:ring-primary-500" />
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="auth-submit-btn">
                        <span>Sign in</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
