<nav x-data="{ open: false, isDark: document.getElementById('html-root')?.classList.contains('dark') || false }" @theme-changed.window="isDark = $event.detail.isDark" class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-200/70 dark:border-slate-800 sticky top-0 z-50 transition-colors duration-200">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center gap-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 font-display font-bold text-xl tracking-tight text-slate-900 dark:text-white transition-colors">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-primary-600 to-indigo-500 flex items-center justify-center text-white shadow-md shadow-primary-500/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="hidden sm:inline">Budget<span class="text-primary-600 dark:text-primary-400">X</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 lg:space-x-2 sm:ms-8 sm:flex items-center">
                    @if(auth()->user()->isAdmin())
                        <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.*')">
                            <i class="fa-solid fa-shield-halved mr-1.5 text-xs text-rose-500"></i> {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('admin.users') }}" :active="request()->routeIs('admin.users')">
                            <i class="fa-solid fa-users mr-1.5 text-xs text-indigo-500"></i> {{ __('Users') }}
                        </x-nav-link>
                    @else
                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                            <i class="fa-solid fa-chart-line mr-1.5 text-xs text-indigo-500"></i> {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('incomes.index') }}" :active="request()->routeIs('incomes.*')">
                            <i class="fa-solid fa-wallet mr-1.5 text-xs text-emerald-500"></i> {{ __('Income') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('expenses.index') }}" :active="request()->routeIs('expenses.*')">
                            <i class="fa-solid fa-receipt mr-1.5 text-xs text-rose-500"></i> {{ __('Expenses') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('savings-goals.index') }}" :active="request()->routeIs('savings-goals.*')">
                            <i class="fa-solid fa-bullseye mr-1.5 text-xs text-amber-500"></i> {{ __('Goals') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('categories.index') }}" :active="request()->routeIs('categories.*')">
                            <i class="fa-solid fa-tags mr-1.5 text-xs text-purple-500"></i> {{ __('Categories') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('budgets.index') }}" :active="request()->routeIs('budgets.*')">
                            <i class="fa-solid fa-users mr-1.5 text-xs text-blue-500"></i> {{ __('Shared Budgets') }}
                        </x-nav-link>
                        @if(auth()->user()->hasRole('premium') || auth()->user()->hasRole('admin'))
                        <x-nav-link href="{{ route('analytics') }}" :active="request()->routeIs('analytics')">
                            <i class="fa-solid fa-chart-pie mr-1.5 text-xs text-purple-500"></i> {{ __('Analytics') }}
                        </x-nav-link>
                        @endif
                        <x-nav-link href="{{ route('subscribe') }}" :active="request()->routeIs('subscribe')">
                            <i class="fa-solid fa-crown mr-1.5 text-xs text-amber-500"></i> {{ __('Pricing') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-2">
                <!-- Premium Badge -->
                @if(auth()->user()->hasRole('premium'))
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900/50 dark:to-purple-900/50 text-indigo-700 dark:text-indigo-300 rounded-full text-xs font-bold border border-indigo-200 dark:border-indigo-800">
                        <i class="fa-solid fa-crown text-amber-500"></i> Premium
                    </span>
                @endif

                <!-- Dark Mode Toggle Button -->
                <button type="button" @click="toggleDarkMode(); isDark = !isDark" aria-label="Toggle dark mode"
                    class="p-2 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <svg x-show="!isDark" class="w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="isDark" class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>

                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ms-1 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-xl">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-slate-200 dark:border-slate-700 text-sm leading-4 font-semibold rounded-xl text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700/60 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-slate-400 font-semibold uppercase tracking-wider">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <!-- Team Switcher -->
                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-slate-100 dark:border-slate-700"></div>

                                        <div class="block px-4 py-2 text-xs text-slate-400 font-semibold uppercase tracking-wider">
                                            {{ __('Switch Teams') }}
                                        </div>

                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-primary-400 transition">
                                    <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-xl">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-slate-200 dark:border-slate-700 text-sm leading-4 font-semibold rounded-xl text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700/60 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                                        <i class="fa-solid fa-user-circle mr-2 text-slate-400"></i>
                                        {{ Auth::user()->name }}

                                        <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            @if(!auth()->user()->isAdmin())
                                <div class="block px-4 py-2 text-xs text-slate-400 font-semibold uppercase tracking-wider">
                                    {{ __('Manage Account') }}
                                </div>

                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    <i class="fa-solid fa-user mr-2 text-slate-400"></i> {{ __('Profile') }}
                                </x-dropdown-link>

                                <div class="border-t border-slate-100 dark:border-slate-700"></div>
                            @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    <i class="fa-solid fa-right-from-bracket mr-2 text-rose-500"></i> {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger & Mobile Dark Toggle -->
            <div class="-me-2 flex items-center sm:hidden gap-1">
                <button type="button" @click="toggleDarkMode(); isDark = !isDark" aria-label="Toggle dark mode"
                    class="p-2 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors focus:outline-none">
                    <svg x-show="!isDark" class="w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="isDark" class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-slate-500 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 shadow-xl transition-colors duration-200">
        <div class="pt-2 pb-3 space-y-1">
            @if(auth()->user()->isAdmin())
                <x-responsive-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                    <i class="fa-solid fa-shield-halved mr-2 text-rose-500"></i> {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('admin.users') }}" :active="request()->routeIs('admin.users')">
                    <i class="fa-solid fa-users mr-2 text-indigo-500"></i> {{ __('Users') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    <i class="fa-solid fa-chart-line mr-2 text-indigo-500"></i> {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('incomes.index') }}" :active="request()->routeIs('incomes.*')">
                    <i class="fa-solid fa-wallet mr-2 text-emerald-500"></i> {{ __('Income') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('expenses.index') }}" :active="request()->routeIs('expenses.*')">
                    <i class="fa-solid fa-receipt mr-2 text-rose-500"></i> {{ __('Expenses') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('savings-goals.index') }}" :active="request()->routeIs('savings-goals.*')">
                    <i class="fa-solid fa-bullseye mr-2 text-amber-500"></i> {{ __('Goals') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('categories.index') }}" :active="request()->routeIs('categories.*')">
                    <i class="fa-solid fa-tags mr-2 text-purple-500"></i> {{ __('Categories') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('budgets.index') }}" :active="request()->routeIs('budgets.*')">
                    <i class="fa-solid fa-users mr-2 text-blue-500"></i> {{ __('Shared Budgets') }}
                </x-responsive-nav-link>
                @if(auth()->user()->hasRole('premium') || auth()->user()->hasRole('admin'))
                <x-responsive-nav-link href="{{ route('analytics') }}" :active="request()->routeIs('analytics')">
                    <i class="fa-solid fa-chart-pie mr-2 text-purple-500"></i> {{ __('Analytics') }}
                </x-responsive-nav-link>
                @endif
                <x-responsive-nav-link href="{{ route('subscribe') }}" :active="request()->routeIs('subscribe')">
                    <i class="fa-solid fa-crown mr-2 text-amber-500"></i> {{ __('Pricing') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-slate-200 dark:border-slate-800">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-semibold text-base text-slate-800 dark:text-slate-100">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-slate-500 dark:text-slate-400">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                @if(!auth()->user()->isAdmin())
                    <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                        <i class="fa-solid fa-user mr-2 text-slate-400"></i> {{ __('Profile') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}"
                                   @click.prevent="$root.submit();">
                        <i class="fa-solid fa-right-from-bracket mr-2 text-rose-500"></i> {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-slate-200 dark:border-slate-800"></div>

                    <div class="block px-4 py-2 text-xs text-slate-400 font-semibold uppercase tracking-wider">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <!-- Team Switcher -->
                    @if (Auth::user()->allTeams()->count() > 1)
                        <div class="border-t border-slate-200 dark:border-slate-800"></div>

                        <div class="block px-4 py-2 text-xs text-slate-400 font-semibold uppercase tracking-wider">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-switchable-team :team="$team" component="responsive-nav-link" />
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</nav>
