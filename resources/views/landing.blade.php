<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BudgetX — Modern Personal Finance & Budgeting</title>
    <meta name="description" content="Take control of your finances with BudgetX. Track expenses, set goals, and monitor your wealth with advanced analytics." />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet" />
    
    <!-- Tailwind / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-display { font-family: 'Outfit', sans-serif; }
        .glass-nav { background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }
        .hero-gradient { background: radial-gradient(circle at 50% 0%, #1e1b4b 0%, #0f172a 75%, #020617 100%); }
        .text-gradient { background: linear-gradient(135deg, #818cf8 0%, #c084fc 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .grid-pattern {
            background-image: linear-gradient(to right, rgba(99, 102, 241, 0.08) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(99, 102, 241, 0.08) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased bg-slate-950 text-slate-100 selection:bg-indigo-500 selection:text-white" x-data="{ mobileOpen: false }">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass-nav border-b border-slate-800/80 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 font-display font-bold text-2xl tracking-tight text-white transition-colors">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-primary-600 to-indigo-500 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span>Budget<span class="text-indigo-400">X</span></span>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-sm font-semibold text-slate-300 hover:text-white transition-colors">Features</a>
                    <a href="#pricing" class="text-sm font-semibold text-slate-300 hover:text-white transition-colors">Pricing</a>
                    <a href="#testimonials" class="text-sm font-semibold text-slate-300 hover:text-white transition-colors">Testimonials</a>
                    <a href="#faq" class="text-sm font-semibold text-slate-300 hover:text-white transition-colors">FAQ</a>
                </div>

                <!-- Auth CTA -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-200 hover:text-white transition flex items-center gap-1.5">
                            <i class="fa-solid fa-chart-line text-xs text-indigo-400"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-300 hover:text-white transition">Log in</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-semibold rounded-xl text-white bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-600/30 transition-all hover:-translate-y-0.5">
                            Get Started Free
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button" @click="mobileOpen = !mobileOpen" class="text-slate-400 hover:text-white p-2 rounded-xl focus:outline-none" aria-label="Toggle navigation">
                        <i :class="mobileOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'" class="text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Functional Mobile Menu -->
        <div x-show="mobileOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" class="md:hidden bg-slate-900 border-b border-slate-800 px-4 pt-3 pb-6 space-y-3">
            <a href="#features" @click="mobileOpen = false" class="block px-3 py-2 rounded-xl text-base font-medium text-slate-300 hover:text-white hover:bg-slate-800">Features</a>
            <a href="#pricing" @click="mobileOpen = false" class="block px-3 py-2 rounded-xl text-base font-medium text-slate-300 hover:text-white hover:bg-slate-800">Pricing</a>
            <a href="#testimonials" @click="mobileOpen = false" class="block px-3 py-2 rounded-xl text-base font-medium text-slate-300 hover:text-white hover:bg-slate-800">Testimonials</a>
            <a href="#faq" @click="mobileOpen = false" class="block px-3 py-2 rounded-xl text-base font-medium text-slate-300 hover:text-white hover:bg-slate-800">FAQ</a>
            
            <div class="pt-3 border-t border-slate-800 space-y-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-xl text-base font-semibold text-indigo-400 hover:bg-slate-800">
                        <i class="fa-solid fa-chart-line mr-2"></i> Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-xl text-base font-medium text-slate-300 hover:text-white hover:bg-slate-800">Log in</a>
                    <a href="{{ route('register') }}" class="block text-center px-4 py-3 rounded-xl text-base font-bold text-white bg-indigo-600 hover:bg-indigo-500 shadow-md">Get Started Free</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative hero-gradient pt-32 pb-20 lg:pt-44 lg:pb-32 overflow-hidden">
        <!-- Dark grid pattern & Ambient glows from SSP1 -->
        <div class="absolute inset-0 grid-pattern pointer-events-none"></div>
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-purple-600/20 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-indigo-600/30 blur-3xl pointer-events-none"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-12 items-center">
                
                <!-- Left Hero Text -->
                <div class="text-center lg:text-left lg:col-span-7">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-slate-800/80 border border-slate-700 backdrop-blur-sm mb-6">
                        <span class="flex h-2 w-2 relative">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                        </span>
                        <span class="text-xs font-semibold text-indigo-300 uppercase tracking-wide">Personal finance tracking made simple</span>
                    </div>
                    
                    <h1 class="text-4xl sm:text-6xl font-display font-extrabold text-white tracking-tight leading-tight mb-6">
                        Master your money.<br/>
                        <span class="text-gradient">Achieve your goals.</span>
                    </h1>
                    
                    <p class="text-lg sm:text-xl text-slate-300 mb-8 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                        BudgetX gives you the clarity to track every penny, plan for the future, and finally take control of your financial wellbeing—all in one beautiful, premium dashboard.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row justify-center lg:justify-start items-center gap-4">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-4 text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-500 shadow-xl shadow-indigo-600/30 hover:-translate-y-0.5 transition-all">
                            Start for free today
                            <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                        </a>
                        <a href="#features" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-4 text-base font-bold rounded-xl text-slate-300 bg-slate-900/80 border border-slate-800 hover:bg-slate-800 hover:text-white transition-all">
                            See how it works
                        </a>
                    </div>
                </div>

                <!-- Right Hero: SSP1 Glassmorphism Preview Dashboard Card -->
                <div class="mt-14 lg:mt-0 lg:col-span-5 relative">
                    <div class="relative mx-auto w-full max-w-md rounded-3xl shadow-2xl animate-float bg-slate-900/90 backdrop-blur-xl border border-slate-700/60 p-6 sm:p-7 z-10 overflow-hidden">
                        <!-- Top Accent Highlight -->
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-indigo-500 to-transparent opacity-75"></div>
                        
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-semibold text-slate-400">Total Balance</span>
                            <span class="inline-flex items-center gap-1 text-xs text-emerald-400 font-bold px-2.5 py-1 bg-emerald-950/60 border border-emerald-800/50 rounded-full">
                                <i class="fa-solid fa-arrow-trend-up text-[10px]"></i> +12.5% this month
                            </span>
                        </div>
                        <div class="text-4xl font-display font-extrabold text-white mb-6 tracking-tight">{{ auth()->user()?->formatCurrency(385450) ?? '$385,450.00' }}</div>
                        
                        <div class="space-y-3.5">
                            <!-- Transaction 1: Salary -->
                            <div class="flex items-center justify-between p-3.5 bg-slate-800/70 border border-slate-700/50 rounded-2xl hover:bg-slate-800 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center text-emerald-400 border border-emerald-500/30">
                                        <i class="fa-solid fa-arrow-down text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-slate-100">Salary & Bonus</div>
                                        <div class="text-xs text-slate-400">Today, 9:00 AM</div>
                                    </div>
                                </div>
                                <div class="text-sm font-bold text-emerald-400">+{{ auth()->user()?->formatCurrency(125000) ?? '$125,000.00' }}</div>
                            </div>

                            <!-- Transaction 2: Groceries -->
                            <div class="flex items-center justify-between p-3.5 bg-slate-800/70 border border-slate-700/50 rounded-2xl hover:bg-slate-800 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-rose-500/20 flex items-center justify-center text-rose-400 border border-rose-500/30">
                                        <i class="fa-solid fa-cart-shopping text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-slate-100">Groceries & Food</div>
                                        <div class="text-xs text-slate-400">Yesterday, 6:30 PM</div>
                                    </div>
                                </div>
                                <div class="text-sm font-bold text-slate-200">-{{ auth()->user()?->formatCurrency(8450) ?? '$8,450.00' }}</div>
                            </div>

                            <!-- Transaction 3: Goal contribution -->
                            <div class="flex items-center justify-between p-3.5 bg-slate-800/70 border border-slate-700/50 rounded-2xl hover:bg-slate-800 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center text-amber-400 border border-amber-500/30">
                                        <i class="fa-solid fa-bullseye text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-slate-100">Emergency Fund Goal</div>
                                        <div class="text-xs text-slate-400">2 days ago</div>
                                    </div>
                                </div>
                                <div class="text-sm font-bold text-amber-400">85% Funded</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-slate-900 border-t border-slate-800 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-indigo-400 font-semibold tracking-wide uppercase text-sm mb-3">Core Features</h2>
                <h3 class="text-3xl md:text-5xl font-display font-bold text-white mb-4">Everything you need to succeed financially</h3>
                <p class="text-lg text-slate-400">We've stripped away the complexity, leaving only the powerful tools that actually help you grow your wealth.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-slate-800/80 rounded-3xl p-8 border border-slate-700/70 hover:border-indigo-500/50 hover:shadow-xl transition-all duration-300 group">
                    <div class="w-14 h-14 bg-indigo-500/20 rounded-2xl flex items-center justify-center text-indigo-400 mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-wallet text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-display font-bold text-white mb-3">Smart Budgeting</h4>
                    <p class="text-slate-400 leading-relaxed">Set custom monthly limits for groceries, entertainment, and utilities. Visual progress indicators keep you accountable instantly.</p>
                </div>
                <!-- Feature 2 -->
                <div class="bg-slate-800/80 rounded-3xl p-8 border border-slate-700/70 hover:border-purple-500/50 hover:shadow-xl transition-all duration-300 group">
                    <div class="w-14 h-14 bg-purple-500/20 rounded-2xl flex items-center justify-center text-purple-400 mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-chart-pie text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-display font-bold text-white mb-3">Advanced Analytics</h4>
                    <p class="text-slate-400 leading-relaxed">Interactive charts break down your spending trends. Identify cash flow patterns and prevent spending leaks.</p>
                </div>
                <!-- Feature 3 -->
                <div class="bg-slate-800/80 rounded-3xl p-8 border border-slate-700/70 hover:border-emerald-500/50 hover:shadow-xl transition-all duration-300 group">
                    <div class="w-14 h-14 bg-emerald-500/20 rounded-2xl flex items-center justify-center text-emerald-400 mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-bullseye text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-display font-bold text-white mb-3">Savings Goals</h4>
                    <p class="text-slate-400 leading-relaxed">Planning a vacation or building an emergency fund? Set target dates and amounts, and track contributions with precision.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 bg-slate-950 border-t border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-indigo-400 font-semibold tracking-wide uppercase text-sm mb-3">Pricing</h2>
                <h3 class="text-3xl md:text-5xl font-display font-bold text-white mb-4">Simple, transparent plans</h3>
                <p class="text-lg text-slate-400">Start for free and upgrade whenever you need power-user tools.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto items-stretch">
                <!-- Free Tier -->
                <div class="bg-slate-900 rounded-3xl p-8 border border-slate-800 shadow-sm relative flex flex-col">
                    <h4 class="font-display font-bold text-2xl text-white mb-2">Basic</h4>
                    <p class="text-slate-400 text-sm mb-6">Perfect for personal finance tracking.</p>
                    <div class="mb-8">
                        <span class="text-5xl font-extrabold text-white">{{ auth()->user()?->formatCurrency(0) ?? '$0.00' }}</span>
                        <span class="text-slate-400 font-medium">/month</span>
                    </div>
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start gap-3"><i class="fa-solid fa-check text-emerald-400 mt-1"></i> <span class="text-slate-300">Expense & Income Tracking</span></li>
                        <li class="flex items-start gap-3"><i class="fa-solid fa-check text-emerald-400 mt-1"></i> <span class="text-slate-300">Active Shared Budgets</span></li>
                        <li class="flex items-start gap-3"><i class="fa-solid fa-check text-emerald-400 mt-1"></i> <span class="text-slate-300">Category Tagging</span></li>
                        <li class="flex items-start gap-3"><i class="fa-solid fa-check text-emerald-400 mt-1"></i> <span class="text-slate-300">Savings Goals Tracking</span></li>
                    </ul>
                    <a href="{{ route('register') }}" class="w-full inline-block text-center py-4 rounded-xl font-bold text-slate-200 bg-slate-800 hover:bg-slate-700 transition-colors">Get Started Free</a>
                </div>

                <!-- Premium Tier -->
                <div class="bg-gradient-to-b from-indigo-950/80 to-slate-900 rounded-3xl p-8 border border-indigo-500/40 shadow-2xl relative flex flex-col transform md:-translate-y-2">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-xs font-bold uppercase tracking-wider py-1 px-4 rounded-full shadow-md">Most Popular</div>
                    <h4 class="font-display font-bold text-2xl text-white mb-2">Premium</h4>
                    <p class="text-indigo-200 text-sm mb-6">For serious financial growth.</p>
                    <div class="mb-8">
                        <span class="text-5xl font-extrabold text-white">{{ auth()->user()?->formatCurrency(990) ?? '$990.00' }}</span>
                        <span class="text-indigo-300 font-medium">/month</span>
                    </div>
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start gap-3"><i class="fa-solid fa-check text-indigo-400 mt-1"></i> <span class="text-white">Everything in Basic</span></li>
                        <li class="flex items-start gap-3"><i class="fa-solid fa-check text-indigo-400 mt-1"></i> <span class="text-white">Unlimited Budgets & Collaborators</span></li>
                        <li class="flex items-start gap-3"><i class="fa-solid fa-check text-indigo-400 mt-1"></i> <span class="text-white">Advanced Chart Analytics & Forecasts</span></li>
                        <li class="flex items-start gap-3"><i class="fa-solid fa-check text-indigo-400 mt-1"></i> <span class="text-white">Priority Cloud Sync & Backup</span></li>
                    </ul>
                    <a href="{{ route('register') }}" class="w-full inline-block text-center py-4 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-600/30 transition-all hover:scale-[1.02]">Start Free Trial</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="py-24 bg-slate-900 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-3xl md:text-5xl font-display font-bold text-white text-center mb-16">Loved by thousands</h3>
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Review 1 -->
                <div class="p-6 bg-slate-800/70 border border-slate-700/60 rounded-2xl">
                    <div class="flex gap-1 text-amber-400 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="text-slate-300 mb-6 font-normal leading-relaxed">"BudgetX completely changed how I view my money. The UI is gorgeous and it's incredibly easy to use. I saved thousands my first month just by seeing where my money was going."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-500/20 rounded-full flex items-center justify-center font-bold text-indigo-400 border border-indigo-500/30">SJ</div>
                        <div>
                            <p class="font-bold text-white text-sm">Sarah Jenkins</p>
                            <p class="text-xs text-slate-400">Freelance Designer</p>
                        </div>
                    </div>
                </div>
                <!-- Review 2 -->
                <div class="p-6 bg-slate-800/70 border border-slate-700/60 rounded-2xl">
                    <div class="flex gap-1 text-amber-400 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="text-slate-300 mb-6 font-normal leading-relaxed">"The Premium analytics are worth every penny. I can forecast my cash flow and easily track my emergency fund goals. The best finance app on the market."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-500/20 rounded-full flex items-center justify-center font-bold text-purple-400 border border-purple-500/30">MR</div>
                        <div>
                            <p class="font-bold text-white text-sm">Michael Ross</p>
                            <p class="text-xs text-slate-400">Software Engineer</p>
                        </div>
                    </div>
                </div>
                <!-- Review 3 -->
                <div class="p-6 bg-slate-800/70 border border-slate-700/60 rounded-2xl">
                    <div class="flex gap-1 text-amber-400 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="text-slate-300 mb-6 font-normal leading-relaxed">"I used to hate budgeting, but the visual progress bars make it feel like a game. Highly recommend the free version for anyone trying to take charge of their finances!"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-500/20 rounded-full flex items-center justify-center font-bold text-emerald-400 border border-emerald-500/30">EL</div>
                        <div>
                            <p class="font-bold text-white text-sm">Emma Lawson</p>
                            <p class="text-xs text-slate-400">Business Owner</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-24 bg-slate-950 border-t border-slate-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-3xl md:text-5xl font-display font-bold text-white text-center mb-12">Frequently Asked Questions</h3>
            <div class="space-y-4">
                <div class="bg-slate-900 p-6 rounded-2xl border border-slate-800">
                    <h4 class="font-bold text-lg text-white mb-2">Is the Free plan actually free forever?</h4>
                    <p class="text-slate-400">Yes! The Basic tier is 100% free forever. It covers all the essential tools you need to track income, expenses, and savings goals.</p>
                </div>
                <div class="bg-slate-900 p-6 rounded-2xl border border-slate-800">
                    <h4 class="font-bold text-lg text-white mb-2">Is my financial data secure?</h4>
                    <p class="text-slate-400">Security is our highest priority. BudgetX uses bank-grade encryption, modern 2FA authentication, and will never sell your data to third parties.</p>
                </div>
                <div class="bg-slate-900 p-6 rounded-2xl border border-slate-800">
                    <h4 class="font-bold text-lg text-white mb-2">Can I cancel my Premium subscription anytime?</h4>
                    <p class="text-slate-400">Absolutely. You can manage or cancel your subscription directly from your settings panel. No lock-ins or hidden cancellation fees.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 relative overflow-hidden bg-gradient-to-r from-indigo-900 to-purple-950 border-t border-indigo-800/50">
        <div class="relative max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-4xl md:text-5xl font-display font-bold text-white mb-6">Ready to take control?</h2>
            <p class="text-xl text-indigo-200 mb-10">Join thousands of users who are building wealth and achieving financial freedom today.</p>
            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-10 py-5 text-lg font-bold rounded-xl text-indigo-950 bg-white hover:bg-slate-100 shadow-2xl transition-transform hover:scale-105">
                Create your free account
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 pt-16 pb-8 border-t border-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
                <div class="col-span-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 font-display font-bold text-xl text-white mb-4">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-primary-600 to-indigo-500 flex items-center justify-center text-white shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span>Budget<span class="text-indigo-400">X</span></span>
                    </a>
                    <p class="text-slate-400 text-sm max-w-xs leading-relaxed">
                        The ultimate personal finance SaaS platform designed for the modern wealth builder.
                    </p>
                </div>
                <div>
                    <h5 class="text-white font-semibold mb-4 tracking-wider text-sm uppercase">Product</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#features" class="text-slate-400 hover:text-indigo-400 transition-colors">Features</a></li>
                        <li><a href="#pricing" class="text-slate-400 hover:text-indigo-400 transition-colors">Pricing</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-white font-semibold mb-4 tracking-wider text-sm uppercase">Quick Links</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('login') }}" class="text-slate-400 hover:text-indigo-400 transition-colors">Login</a></li>
                        <li><a href="{{ route('register') }}" class="text-slate-400 hover:text-indigo-400 transition-colors">Register</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-900 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-500 text-sm">© {{ date('Y') }} BudgetX. All rights reserved. Designed for financial freedom.</p>
                <div class="flex gap-4 text-slate-500">
                    <span class="text-xs text-slate-600">Built with Laravel 12 & Livewire 3</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
