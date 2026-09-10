<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-primary-600 border border-transparent rounded-xl font-semibold text-sm text-white shadow-sm shadow-primary-500/25 hover:bg-primary-700 hover:shadow-md focus:bg-primary-700 active:scale-95 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 disabled:opacity-50 transition-all duration-150']) }}>
    {{ $slot }}
</button>
