<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-rose-600 border border-transparent rounded-xl font-semibold text-sm text-white shadow-sm shadow-rose-500/25 hover:bg-rose-700 hover:shadow-md active:scale-95 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 disabled:opacity-50 transition-all duration-150']) }}>
    {{ $slot }}
</button>
