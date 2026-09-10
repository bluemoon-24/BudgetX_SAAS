<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2 font-display">
                <i class="fa-solid fa-bullseye text-amber-500"></i> Financial Goals
            </h2>
            <a href="{{ route('savings-goals.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-500/20 hover:bg-indigo-700 transition flex items-center gap-1.5">
                <i class="fa-solid fa-plus text-xs"></i> New Goal
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl text-sm font-medium flex items-center gap-3">
                    <i class="fa-solid fa-check-circle text-xl"></i> {{ session('success') }}
                </div>
            @endif

            @if($goals->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($goals as $goal)
                        @php
                            $paid = $goal->payments->sum('amount') ?: $goal->current_amount;
                            $target = $goal->target_amount;
                            $pct = $target > 0 ? min(round(($paid / $target) * 100), 100) : 0;
                            $color = $pct >= 100 ? 'emerald' : ($pct >= 75 ? 'indigo' : ($pct >= 50 ? 'amber' : 'purple'));
                        @endphp
                        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="font-bold text-lg text-slate-800 truncate" title="{{ $goal->name }}">
                                        <a href="{{ route('savings-goals.show', $goal) }}" class="hover:text-indigo-600 transition">
                                            {{ $goal->name }}
                                        </a>
                                    </h3>
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-{{ $color }}-50 text-{{ $color }}-700 border border-{{ $color }}-100">
                                        {{ $pct }}%
                                    </span>
                                </div>

                                @if($goal->target_date)
                                    <p class="text-xs text-slate-400 mb-4 flex items-center gap-1.5">
                                        <i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($goal->target_date)->format('M d, Y') }}
                                    </p>
                                @endif

                                <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden mb-3">
                                    <div class="h-full rounded-full bg-{{ $color }}-500 transition-all duration-500" style="width: {{ $pct }}%"></div>
                                </div>

                                <div class="flex justify-between text-xs text-slate-500 font-semibold mb-6">
                                    <span>{{ auth()->user()?->formatCurrency($paid) ?? '$' . number_format($paid, 2) }}</span>
                                    <span>Target: {{ auth()->user()?->formatCurrency($target) ?? '$' . number_format($target, 2) }}</span>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                                <a href="{{ route('savings-goals.show', $goal) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                                    View Contributions &rarr;
                                </a>
                                <div class="flex items-center gap-1.5">
                                    <a href="{{ route('savings-goals.edit', $goal) }}" class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition" title="Edit">
                                        <i class="fa-solid fa-pen text-[11px]"></i>
                                    </a>
                                    <form method="POST" action="{{ route('savings-goals.destroy', $goal) }}" onsubmit="return confirm('Delete this goal?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Delete">
                                            <i class="fa-solid fa-trash text-[11px]"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $goals->links() }}
                </div>
            @else
                <div class="py-16 text-center text-slate-500 bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
                    <div class="w-16 h-16 rounded-full bg-amber-50 flex items-center justify-center mx-auto mb-4 text-amber-500 text-2xl">
                        <i class="fa-solid fa-bullseye"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-800 mb-1 font-display">No financial goals created yet</h3>
                    <p class="text-xs text-slate-400 max-w-sm mx-auto mb-6">Create your personal savings targets to track contributions and progress towards financial milestones.</p>
                    <a href="{{ route('savings-goals.create') }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 text-white text-xs font-bold rounded-xl hover:bg-indigo-700 shadow-sm transition">
                        <i class="fa-solid fa-plus mr-1.5"></i> Create Your First Goal
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
