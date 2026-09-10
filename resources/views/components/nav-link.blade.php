@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-2 pt-1 border-b-2 border-primary-500 text-sm font-semibold leading-5 text-primary-600 dark:text-primary-400 focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center px-2 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 hover:border-slate-300 dark:hover:border-slate-700 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
