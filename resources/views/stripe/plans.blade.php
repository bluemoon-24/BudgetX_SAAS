<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight font-display flex items-center gap-2">
            <i class="fa-solid fa-crown text-amber-500"></i> Upgrade Your Plan
        </h2>
    </x-slot>

    @if ($errors->has('stripe'))
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700" role="alert">
                {{ $errors->first('stripe') }}
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Heading -->
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-indigo-50 dark:bg-indigo-950/50 text-indigo-700 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800 mb-3 inline-block">
                    Transparent Pricing
                </span>
                <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white font-display tracking-tight mb-4">
                    Invest in Your Financial Freedom
                </h3>
                <p class="text-base text-slate-500 dark:text-slate-400 max-w-xl mx-auto">
                    Choose the plan that matches your goals. Upgrade to unlock powerful analytics, overspending notifications, and shared budgets.
                </p>
            </div>

            <!-- Pricing Grid -->
            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto items-stretch">
                <!-- Basic Plan -->
                <div class="bg-white dark:bg-slate-800/90 rounded-3xl p-8 border border-slate-200 dark:border-slate-700/80 shadow-sm flex flex-col justify-between transition-colors">
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="font-bold text-xl text-slate-800 dark:text-white font-display">Basic Plan</h4>
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">Standard</span>
                        </div>
                        <p class="text-slate-500 dark:text-slate-400 text-xs mb-6">Core income & expense tracking for individual users.</p>
                        
                        <div class="mb-6">
                            <span class="text-4xl font-extrabold text-slate-900 dark:text-white font-display">Free</span>
                            <span class="text-xs text-slate-400">/ forever</span>
                        </div>

                        <ul class="space-y-3 text-xs text-slate-600 dark:text-slate-300 mb-8 border-t border-slate-100 dark:border-slate-700 pt-6">
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500"></i> Income & expense ledger
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500"></i> Personal savings goals
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500"></i> Standard category tags
                            </li>
                            <li class="flex items-center gap-2.5 text-slate-400 line-through">
                                <i class="fa-solid fa-xmark text-slate-300 dark:text-slate-600"></i> Rule-based overspending alerts
                            </li>
                            <li class="flex items-center gap-2.5 text-slate-400 line-through">
                                <i class="fa-solid fa-xmark text-slate-300 dark:text-slate-600"></i> 12-month trend charts
                            </li>
                            <li class="flex items-center gap-2.5 text-slate-400 line-through">
                                <i class="fa-solid fa-xmark text-slate-300 dark:text-slate-600"></i> Shared budget collaboration
                            </li>
                        </ul>
                    </div>

                    @if(!auth()->user()->hasRole('premium'))
                        <button disabled class="w-full text-center py-3.5 rounded-xl font-bold text-xs text-slate-400 bg-slate-100 dark:bg-slate-700/50 cursor-not-allowed">
                            Current Plan
                        </button>
                    @else
                        <span class="text-center text-xs text-slate-400">Included with your subscription</span>
                    @endif
                </div>

                <!-- Monthly Premium -->
                <div class="bg-gradient-to-br from-slate-900 via-indigo-950 to-indigo-900 rounded-3xl p-8 border border-indigo-500/30 shadow-xl shadow-indigo-900/20 text-white flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/20 rounded-full blur-2xl"></div>
                    <div>
                        <div class="flex justify-between items-center mb-4 relative z-10">
                            <h4 class="font-bold text-xl text-white font-display">Premium Monthly</h4>
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-indigo-500/30 text-indigo-200 border border-indigo-400/30">Flexible</span>
                        </div>
                        <p class="text-indigo-200 text-xs mb-6 relative z-10">Full access to advanced analytics and collaboration.</p>
                        
                        <div class="mb-6 relative z-10">
                            <span class="text-4xl font-extrabold text-white font-display">LKR 500</span>
                            <span class="text-xs text-indigo-300">/ month</span>
                        </div>

                        <ul class="space-y-3 text-xs text-indigo-100 mb-8 border-t border-indigo-800/60 pt-6 relative z-10">
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-400"></i> Everything in Basic
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-400"></i> Rule-based overspending alerts
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-400"></i> 12-month trend charts & export
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-400"></i> Shared budget collaboration
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-400"></i> Priority feature updates
                            </li>
                        </ul>
                    </div>

                    <form action="{{ route('stripe.checkout') }}" method="POST" class="mt-auto relative z-10">
                        @csrf
                        <input type="hidden" name="plan" value="monthly">
                        <button type="submit" class="w-full text-center py-3.5 rounded-xl font-bold text-xs text-indigo-950 bg-white hover:bg-indigo-50 transition shadow-lg hover:scale-105 active:scale-95">
                            @if(auth()->user()->hasRole('premium')) Renew Monthly @else Upgrade to Monthly @endif
                        </button>
                    </form>
                </div>

                <!-- Yearly Premium (Best Value) -->
                <div class="bg-white dark:bg-slate-800/90 rounded-3xl p-8 border-2 border-indigo-600 shadow-xl flex flex-col justify-between relative transition-colors">
                    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-3.5 py-1 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full text-[11px] font-bold shadow-md">
                        Best Value (Save LKR 1,000/year)
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-4 mt-2">
                            <h4 class="font-bold text-xl text-slate-800 dark:text-white font-display">Premium Annual</h4>
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300">Recommended</span>
                        </div>
                        <p class="text-slate-500 dark:text-slate-400 text-xs mb-6">Annual commitment with two months completely free.</p>
                        
                        <div class="mb-6">
                            <span class="text-4xl font-extrabold text-slate-900 dark:text-white font-display">LKR 5000</span>
                            <span class="text-xs text-slate-400">/ year</span>
                        </div>

                        <ul class="space-y-3 text-xs text-slate-600 dark:text-slate-300 mb-8 border-t border-slate-100 dark:border-slate-700 pt-6">
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500"></i> Everything in Monthly
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500"></i> Save 17% over monthly billing
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500"></i> Unlimited shared goal collaborators
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500"></i> VIP priority support
                            </li>
                        </ul>
                    </div>

                    <form action="{{ route('stripe.checkout') }}" method="POST" class="mt-auto">
                        @csrf
                        <input type="hidden" name="plan" value="yearly">
                        <button type="submit" class="w-full text-center py-3.5 rounded-xl font-bold text-xs text-white bg-indigo-600 hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/25 hover:scale-105 active:scale-95">
                            @if(auth()->user()->hasRole('premium')) Renew Annual @else Upgrade to Annual @endif
                        </button>
                    </form>
                </div>
            </div>

            <!-- Stripe Trust Notice -->
            <div class="text-center mt-12 text-slate-400 text-xs flex items-center justify-center gap-2">
                <i class="fa-solid fa-shield-halved text-emerald-500"></i>
                <span>Protected by 256-bit encrypted checkout via Stripe. Cancel anytime from your profile settings.</span>
            </div>
        </div>
    </div>
</x-app-layout>