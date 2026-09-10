<div>
    <div class="flex justify-between items-center text-xs font-semibold mb-1">
        <span class="text-slate-600">Spent: {{ auth()->user()?->formatCurrency($spent) ?? '$' . number_format($spent, 2) }}</span>
        <span class="text-{{ $color }}-600 font-bold">{{ $pct }}%</span>
    </div>
    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
        <div class="h-full rounded-full bg-{{ $color }}-500 transition-all duration-500 ease-out" style="width: {{ $pct }}%"></div>
    </div>
</div>
