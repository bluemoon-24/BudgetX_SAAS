<x-guest-layout>
    <div class="auth-page-wrapper">
        <!-- Animated background orbs -->
        <div class="auth-bg-orb auth-bg-orb-1"></div>
        <div class="auth-bg-orb auth-bg-orb-2"></div>
        <div class="auth-bg-orb auth-bg-orb-3"></div>

        <div class="auth-container animate-fade-in-up" x-data="{ recovery: false }">
            <!-- Logo & Heading -->
            <div class="auth-header">
                <div class="auth-logo-ring">
                    <svg class="auth-logo-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h1 class="auth-title">Two-factor confirmation</h1>
                <p class="auth-subtitle" x-show="! recovery">
                    Enter the authentication code from your authenticator app
                </p>
                <p class="auth-subtitle" x-cloak x-show="recovery">
                    Enter one of your emergency recovery codes
                </p>
            </div>

            <x-validation-errors class="mb-4" />

            <!-- Glass Card -->
            <div class="auth-glass-card animate-fade-in-up" style="animation-delay: 0.15s;">
                <form class="auth-form" method="POST" action="{{ route('two-factor.login') }}">
                    @csrf

                    <!-- Auth Code Field -->
                    <div class="auth-field-group" x-show="! recovery">
                        <label for="code" class="auth-label">Authentication Code</label>
                        <div class="auth-input-wrapper">
                            <div class="auth-input-icon">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input id="code" name="code" type="text" inputmode="numeric" autofocus x-ref="code" autocomplete="one-time-code"
                                placeholder="123456"
                                class="auth-input @error('code') auth-input-error @enderror">
                        </div>
                        @error('code')
                            <p class="auth-error-msg">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Recovery Code Field -->
                    <div class="auth-field-group" x-cloak x-show="recovery">
                        <label for="recovery_code" class="auth-label">Emergency Recovery Code</label>
                        <div class="auth-input-wrapper">
                            <div class="auth-input-icon">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                            </div>
                            <input id="recovery_code" name="recovery_code" type="text" x-ref="recovery_code" autocomplete="one-time-code"
                                placeholder="abcde-12345"
                                class="auth-input @error('recovery_code') auth-input-error @enderror">
                        </div>
                        @error('recovery_code')
                            <p class="auth-error-msg">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Toggle Button -->
                    <div class="flex items-center justify-between pt-1">
                        <button type="button" class="auth-link text-sm"
                            x-show="! recovery"
                            x-on:click="
                                recovery = true;
                                $nextTick(() => { $refs.recovery_code.focus() })
                            ">
                            Use a recovery code
                        </button>

                        <button type="button" class="auth-link text-sm"
                            x-cloak
                            x-show="recovery"
                            x-on:click="
                                recovery = false;
                                $nextTick(() => { $refs.code.focus() })
                            ">
                            Use an authenticator code
                        </button>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="auth-submit-btn">
                        <span>Verify and Log In</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
