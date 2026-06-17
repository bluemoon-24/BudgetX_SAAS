<div class="min-h-screen flex items-center justify-center bg-slate-50 relative overflow-hidden">
    <!-- Clean, non-animated decorative elements -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] bg-indigo-100 rounded-full blur-[100px] pointer-events-none opacity-50"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[500px] h-[500px] bg-purple-100 rounded-full blur-[100px] pointer-events-none opacity-50"></div>

    <div class="relative z-10 w-full max-w-4xl flex bg-white rounded-3xl shadow-xl shadow-slate-200 overflow-hidden mx-4">
        <!-- Image side -->
        <div class="hidden md:flex w-1/2 bg-slate-900 flex-col justify-center items-center p-12 text-center relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/30 to-purple-600/30 mix-blend-overlay"></div>
            <img src="{{ asset('images/dashboard_mockup.png') }}" class="w-[120%] -ml-[10%] rounded-2xl shadow-2xl rotate-[-5deg] mb-8 z-10 border border-white/10" alt="Dashboard Mockup">
            <h2 class="text-3xl font-display font-bold text-white z-10">Master your finances</h2>
            <p class="text-indigo-200 mt-4 z-10">Track expenses, achieve goals, and build wealth with BudgetX Premium.</p>
        </div>

        <!-- Form side -->
        <div class="w-full md:w-1/2 p-8 sm:p-12 flex flex-col justify-center">
            <div class="flex justify-center mb-10">
                {{ $logo }}
            </div>

            {{ $slot }}
        </div>
    </div>
</div>
