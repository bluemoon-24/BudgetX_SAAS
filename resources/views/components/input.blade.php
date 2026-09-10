@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-slate-300 dark:border-slate-700 dark:bg-slate-900/80 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:border-primary-500 focus:ring-2 focus:ring-primary-500 rounded-xl shadow-sm text-sm transition-all duration-150 disabled:bg-slate-50 dark:disabled:bg-slate-950 disabled:text-slate-400']) !!}>
