<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="html-root">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BudgetX') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet" />

        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', sans-serif; }
            .font-display { font-family: 'Outfit', sans-serif; }
            [x-cloak] { display: none !important; }
        </style>

        <script>
            // Apply dark mode before paint to prevent flash
            (function() {
                var theme = localStorage.getItem('budgetx-theme');
                if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.getElementById('html-root').classList.add('dark');
                }
            })();

            function toggleDarkMode() {
                var html = document.getElementById('html-root');
                var isDark = html.classList.toggle('dark');
                localStorage.setItem('budgetx-theme', isDark ? 'dark' : 'light');
                window.dispatchEvent(new CustomEvent('theme-changed', { detail: { isDark: isDark } }));
            }
        </script>

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 font-sans antialiased min-h-screen flex flex-col transition-colors duration-300">
        <x-banner />

        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-900 shadow border-b border-gray-100 dark:border-gray-800 transition-colors duration-300">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <footer class="bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 mt-auto transition-colors duration-300">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex justify-center md:justify-start mb-6 md:mb-0">
                        <a href="/" class="text-xl font-display font-bold text-gray-400 flex items-center gap-2 grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            BudgetX
                        </a>
                    </div>
                    <div class="mt-8 md:mt-0">
                        <p class="text-center text-sm text-gray-500">
                            &copy; {{ date('Y') }} BudgetX. All rights reserved. Designed for financial freedom.
                        </p>
                    </div>
                </div>
            </div>
        </footer>

        @stack('modals')

        @livewireScripts
    </body>
</html>
