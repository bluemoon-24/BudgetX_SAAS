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
        .glass-nav { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .hero-gradient { background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); }
        .text-gradient { background: linear-gradient(to right, #818cf8, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-800 selection:bg-indigo-500 selection:text-white">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass-nav border-b border-slate-200/50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-display font-bold text-xl shadow-lg shadow-indigo-500/30">BX</div>
                    <span class="font-display font-bold text-2xl tracking-tight text-slate-900">Budget<span class="text-indigo-600">X</span></span>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">Features</a>
                    <a href="#pricing" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">Pricing</a>
                    <a href="#testimonials" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">Testimonials</a>
                    <a href="#faq" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">FAQ</a>
                </div>

                <!-- Auth CTA -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-slate-700 hover:text-indigo-600 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-indigo-600 transition">Log in</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-semibold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 shadow-md shadow-indigo-500/20 transition-all hover:-translate-y-0.5">
                            Get Started Free
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="text-slate-500 hover:text-slate-900 focus:outline-none">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative hero-gradient pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <!-- Abstract Shapes -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-purple-600/20 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-indigo-600/30 blur-3xl"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-800/50 border border-slate-700 backdrop-blur-sm mb-8">
                <span class="flex h-2 w-2 relative">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <span class="text-xs font-medium text-slate-300 uppercase tracking-wide">BudgetX 2.0 is now live</span>
            </div>
            
            <h1 class="text-5xl md:text-7xl font-display font-extrabold text-white tracking-tight mb-6 leading-tight">
                Master your money.<br/>
                <span class="text-gradient">Design your future.</span>
            </h1>
            
            <p class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-slate-300 mb-10">
                The most intuitive, powerful, and beautifully designed personal finance tracker. Say goodbye to messy spreadsheets and hello to financial clarity.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-4 text-base font-bold rounded-xl text-indigo-900 bg-white hover:bg-slate-50 transition-all shadow-xl shadow-white/10 hover:scale-105">
                    Start for Free
                    <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
                <a href="#features" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-4 text-base font-bold rounded-xl text-white bg-slate-800 border border-slate-700 hover:bg-slate-700 transition-all">
                    See how it works
                </a>
            </div>

            <!-- Hero Image Mockup -->
            <div class="mt-16 relative max-w-5xl mx-auto z-10">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-3xl blur-xl opacity-30"></div>
                <div class="rounded-3xl bg-slate-900/50 p-2 md:p-3 backdrop-blur-xl border border-white/10 shadow-2xl relative">
                    <img src="{{ asset('images/dashboard_mockup.png') }}" alt="BudgetX Dashboard" class="w-full rounded-2xl shadow-inner border border-white/5">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-slate-50 relative overflow-hidden">
        <!-- Decorative blobs -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-indigo-300/20 blur-3xl mix-blend-multiply"></div>
            <div class="absolute top-[20%] -right-[10%] w-[40%] h-[60%] rounded-full bg-purple-300/20 blur-3xl mix-blend-multiply"></div>
            <div class="absolute -bottom-[20%] left-[20%] w-[60%] h-[50%] rounded-full bg-pink-300/20 blur-3xl mix-blend-multiply"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-indigo-600 font-semibold tracking-wide uppercase text-sm mb-3">Core Features</h2>
                <h3 class="text-3xl md:text-5xl font-display font-bold text-slate-900 mb-4">Everything you need to succeed financially</h3>
                <p class="text-lg text-slate-600">We've stripped away the complexity, leaving only the powerful tools that actually help you grow your wealth.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:border-indigo-100 hover:shadow-xl hover:shadow-indigo-500/5 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-wallet text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-display font-bold text-slate-900 mb-3">Smart Budgeting</h4>
                    <p class="text-slate-600 leading-relaxed">Set custom monthly limits for groceries, entertainment, and more. Visual progress bars keep you accountable instantly.</p>
                </div>
                <!-- Feature 2 -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:border-purple-100 hover:shadow-xl hover:shadow-purple-500/5 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center text-purple-600 mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-chart-pie text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-display font-bold text-slate-900 mb-3">Advanced Analytics</h4>
                    <p class="text-slate-600 leading-relaxed">Interactive charts break down your spending habits. Identify trends and find exactly where your money leaks are.</p>
                </div>
                <!-- Feature 3 -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:border-emerald-100 hover:shadow-xl hover:shadow-emerald-500/5 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-bullseye text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-display font-bold text-slate-900 mb-3">Savings Goals</h4>
                    <p class="text-slate-600 leading-relaxed">Planning a vacation or building an emergency fund? Set targets and watch your progress grow automatically.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 bg-slate-50 border-t border-slate-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-indigo-600 font-semibold tracking-wide uppercase text-sm mb-3">Pricing</h2>
                <h3 class="text-3xl md:text-5xl font-display font-bold text-slate-900 mb-4">Simple, transparent plans</h3>
                <p class="text-lg text-slate-600">Start for free and upgrade when you need power-user tools.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Free Tier -->
                <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm relative flex flex-col">
                    <h4 class="font-display font-bold text-2xl text-slate-900 mb-2">Basic</h4>
                    <p class="text-slate-500 text-sm mb-6">Perfect for getting started.</p>
                    <div class="mb-8">
                        <span class="text-5xl font-extrabold text-slate-900">LKR 0</span>
                        <span class="text-slate-500 font-medium">/month</span>
                    </div>
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start gap-3"><i class="fa-solid fa-check text-green-500 mt-1"></i> <span class="text-slate-700">Expense & Income Tracking</span></li>
                        <li class="flex items-start gap-3"><i class="fa-solid fa-check text-green-500 mt-1"></i> <span class="text-slate-700">Up to 3 Active Budgets</span></li>
                        <li class="flex items-start gap-3"><i class="fa-solid fa-check text-green-500 mt-1"></i> <span class="text-slate-700">Basic Monthly Reports</span></li>
                        <li class="flex items-start gap-3"><i class="fa-solid fa-check text-green-500 mt-1"></i> <span class="text-slate-700">5 Custom Categories</span></li>
                    </ul>
                    <a href="{{ route('register') }}" class="w-full inline-block text-center py-4 rounded-xl font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">Get Started Free</a>
                </div>

                <!-- Premium Tier -->
                <div class="bg-indigo-900 rounded-3xl p-8 border border-indigo-700 shadow-2xl relative flex flex-col transform md:-translate-y-4">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-xs font-bold uppercase tracking-wider py-1 px-4 rounded-full">Most Popular</div>
                    <h4 class="font-display font-bold text-2xl text-white mb-2">Premium</h4>
                    <p class="text-indigo-200 text-sm mb-6">For serious wealth builders.</p>
                    <div class="mb-8">
                        <span class="text-5xl font-extrabold text-white">LKR 9</span>
                        <span class="text-indigo-200 font-medium">/month</span>
                    </div>
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start gap-3"><i class="fa-solid fa-check text-indigo-400 mt-1"></i> <span class="text-white">Everything in Basic</span></li>
                        <li class="flex items-start gap-3"><i class="fa-solid fa-check text-indigo-400 mt-1"></i> <span class="text-white">Unlimited Budgets & Categories</span></li>
                        <li class="flex items-start gap-3"><i class="fa-solid fa-check text-indigo-400 mt-1"></i> <span class="text-white">Advanced Chart Analytics</span></li>
                        <li class="flex items-start gap-3"><i class="fa-solid fa-check text-indigo-400 mt-1"></i> <span class="text-white">Unlimited Savings Goals</span></li>
                        <li class="flex items-start gap-3"><i class="fa-solid fa-check text-indigo-400 mt-1"></i> <span class="text-white">Priority Support</span></li>
                    </ul>
                    <a href="{{ route('register') }}" class="w-full inline-block text-center py-4 rounded-xl font-bold text-indigo-900 bg-white hover:bg-slate-100 shadow-lg shadow-white/10 transition-transform hover:scale-[1.02]">Start Free Trial</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-3xl md:text-5xl font-display font-bold text-slate-900 text-center mb-16">Loved by thousands</h3>
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Review 1 -->
                <div class="p-6 bg-slate-50 border border-slate-100 rounded-2xl">
                    <div class="flex gap-1 text-yellow-400 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="text-slate-700 mb-6 font-medium">"BudgetX completely changed how I view my money. The UI is gorgeous and it's incredibly easy to use. I saved LKR 500 my first month just by seeing where my money was going."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-200 rounded-full flex items-center justify-center font-bold text-indigo-700">SJ</div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm">Sarah Jenkins</p>
                            <p class="text-xs text-slate-500">Freelance Designer</p>
                        </div>
                    </div>
                </div>
                <!-- Review 2 -->
                <div class="p-6 bg-slate-50 border border-slate-100 rounded-2xl">
                    <div class="flex gap-1 text-yellow-400 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="text-slate-700 mb-6 font-medium">"The Premium analytics are worth every penny. I can forecast my cash flow and easily track my emergency fund goals. The best finance app on the market right now."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-200 rounded-full flex items-center justify-center font-bold text-purple-700">MR</div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm">Michael Ross</p>
                            <p class="text-xs text-slate-500">Software Engineer</p>
                        </div>
                    </div>
                </div>
                <!-- Review 3 -->
                <div class="p-6 bg-slate-50 border border-slate-100 rounded-2xl">
                    <div class="flex gap-1 text-yellow-400 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="text-slate-700 mb-6 font-medium">"I used to hate budgeting, but the visual progress bars make it feel like a game. Highly recommend the free version for beginners trying to get a grip on their finances!"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-200 rounded-full flex items-center justify-center font-bold text-emerald-700">EL</div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm">Emma Lawson</p>
                            <p class="text-xs text-slate-500">Student</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-24 bg-slate-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-3xl font-display font-bold text-slate-900 text-center mb-12">Frequently Asked Questions</h3>
            <div class="space-y-4">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h4 class="font-bold text-lg text-slate-900 mb-2">Is the Free plan actually free forever?</h4>
                    <p class="text-slate-600">Yes! The Basic tier is 100% free forever. It covers all the essential tools you need to track basic income, expenses, and up to 3 active budgets.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h4 class="font-bold text-lg text-slate-900 mb-2">Is my financial data secure?</h4>
                    <p class="text-slate-600">Security is our top priority. BudgetX uses bank-level encryption, strict CSRF/XSS protection, and we never sell your data to third parties.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h4 class="font-bold text-lg text-slate-900 mb-2">Can I cancel my Premium subscription anytime?</h4>
                    <p class="text-slate-600">Absolutely. You can manage or cancel your subscription directly from your settings panel. No hidden fees or lock-in contracts.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 relative overflow-hidden">
        <div class="absolute inset-0 hero-gradient"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSIvPjwvc3ZnPg==')]"></div>
        <div class="relative max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-4xl md:text-5xl font-display font-bold text-white mb-6">Ready to take control?</h2>
            <p class="text-xl text-indigo-100 mb-10">Join thousands of users who are building wealth and achieving financial freedom today.</p>
            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-10 py-5 text-lg font-bold rounded-xl text-indigo-900 bg-white hover:bg-indigo-50 shadow-2xl transition-transform hover:scale-105">
                Create your free account
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 pt-16 pb-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
                <div class="col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-display font-bold shadow-lg">BX</div>
                        <span class="font-display font-bold text-xl text-white">Budget<span class="text-indigo-400">X</span></span>
                    </div>
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
                    <h5 class="text-white font-semibold mb-4 tracking-wider text-sm uppercase">Legal</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-slate-400 hover:text-indigo-400 transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-indigo-400 transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-500 text-sm">© {{ date('Y') }} BudgetX Inc. All rights reserved.</p>
                <div class="flex gap-4 text-slate-500">
                    <a href="#" class="hover:text-white transition"><i class="fa-brands fa-twitter text-xl"></i></a>
                    <a href="#" class="hover:text-white transition"><i class="fa-brands fa-github text-xl"></i></a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
