<div class="md:col-span-1 flex justify-between">
    <div class="px-4 sm:px-0">
        <h3 class="text-lg font-bold font-display text-slate-900 dark:text-slate-100 tracking-tight">{{ $title }}</h3>

        <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
            {{ $description }}
        </p>
    </div>

    <div class="px-4 sm:px-0">
        {{ $aside ?? '' }}
    </div>
</div>
