<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight font-display flex items-center gap-2">
                    <i class="fa-solid fa-user-gear text-primary-500"></i> {{ __('My Profile') }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage your account settings, security and preferences.</p>
            </div>

            <div class="flex items-center gap-2">
                @if(auth()->user()->hasRole('admin'))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-300 rounded-full text-xs font-bold border border-rose-200 dark:border-rose-800">
                        <i class="fa-solid fa-shield-halved text-xs"></i> Administrator
                    </span>
                @elseif(auth()->user()->hasRole('premium'))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-950/40 dark:to-purple-950/40 text-indigo-700 dark:text-indigo-300 rounded-full text-xs font-bold border border-indigo-200 dark:border-indigo-800">
                        <i class="fa-solid fa-crown text-amber-500"></i> Premium Member
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-full text-xs font-semibold border border-slate-200 dark:border-slate-700">
                        <i class="fa-solid fa-user text-xs"></i> Standard Member
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <!-- SSP1 Profile Overview Card -->
            <div class="bg-white dark:bg-slate-800/90 rounded-2xl border border-slate-200/80 dark:border-slate-700/80 p-6 sm:p-8 shadow-sm transition-colors">
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                    <div class="relative shrink-0">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <img class="size-20 sm:size-24 rounded-2xl object-cover ring-4 ring-primary-500/20 shadow-md" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        @else
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-gradient-to-tr from-primary-600 to-indigo-500 flex items-center justify-center text-white shadow-md shadow-primary-500/20 text-3xl font-display font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-emerald-500 border-2 border-white dark:border-slate-800" title="Active"></span>
                    </div>

                    <div class="flex-grow text-center sm:text-left">
                        <h3 class="text-xl sm:text-2xl font-bold font-display text-slate-900 dark:text-white tracking-tight">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">{{ Auth::user()->email }}</p>

                        <div class="mt-4 flex flex-wrap items-center justify-center sm:justify-start gap-4 text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                            <span class="flex items-center gap-1.5 font-medium text-emerald-600 dark:text-emerald-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span> Active Account
                            </span>
                            <span class="text-slate-300 dark:text-slate-700">•</span>
                            <span>
                                <i class="fa-regular fa-calendar mr-1"></i> Joined {{ Auth::user()->created_at ? Auth::user()->created_at->format('M Y') : 'Recently' }}
                            </span>
                        </div>
                    </div>

                    @if(!auth()->user()->hasRole('premium') && !auth()->user()->hasRole('admin'))
                        <div class="shrink-0 w-full sm:w-auto mt-2 sm:mt-0">
                            <a href="{{ route('subscribe') }}" class="inline-flex items-center justify-center gap-2 w-full px-5 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold text-sm shadow-md shadow-indigo-500/20 hover:from-indigo-700 hover:to-purple-700 hover:scale-[1.02] active:scale-[0.98] transition-all">
                                <i class="fa-solid fa-crown text-amber-300"></i> Upgrade to Premium
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Jetstream Livewire Profile Sections -->
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')
                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                @livewire('profile.update-password-form')
                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                @livewire('profile.two-factor-authentication-form')
                <x-section-border />
            @endif

            @livewire('profile.logout-other-browser-sessions-form')

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />
                @livewire('profile.delete-user-form')
            @endif
        </div>
    </div>
</x-app-layout>
