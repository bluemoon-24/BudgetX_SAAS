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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h1 class="auth-title">Security check</h1>
                <p class="auth-subtitle">
                    Please confirm your password to continue
                </p>
            </div>

            <x-validation-errors class="mb-4" />

            <!-- Glass Card -->
            <div class="auth-glass-card animate-fade-in-up" style="animation-delay: 0.15s;">
                <p class="text-sm text-slate-600 dark:text-slate-300 mb-6 leading-relaxed">
                    This is a secure area of the application. Please confirm your password before accessing these settings.
                </p>

                <form class="auth-form" method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <!-- Password Field -->
                    <div class="auth-field-group">
                        <label for="password" class="auth-label">Password</label>
                        <div class="auth-input-wrapper">
                            <div class="auth-input-icon">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password" required autofocus
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

                    <!-- Submit Button -->
                    <button type="submit" class="auth-submit-btn">
                        <span>Confirm Password</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
