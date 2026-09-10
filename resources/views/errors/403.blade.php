<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden bg-slate-50 dark:bg-slate-950">
        <!-- Ambient background glows -->
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-rose-500/10 dark:bg-rose-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-amber-500/10 dark:bg-amber-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-md w-full text-center relative z-10 animate-fade-in-up">
            <div class="text-9xl font-black font-display text-rose-200 dark:text-rose-900/60 tracking-tight select-none">
                403
            </div>
            <h1 class="mt-4 text-3xl sm:text-4xl font-bold font-display text-slate-900 dark:text-white tracking-tight">
                Access Denied
            </h1>
            <p class="mt-3 text-base text-slate-500 dark:text-slate-400">
                You do not have permission to access this resource or perform this action.
            </p>
            <div class="mt-8 flex justify-center gap-3">
                <a href="{{ url('/') }}" class="btn-primary px-6 py-3 rounded-xl">
                    <i class="fa-solid fa-house mr-2"></i> Go back home
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
