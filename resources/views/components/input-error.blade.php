@props(['for'])

@error($for)
    <p {{ $attributes->merge(['class' => 'text-sm text-rose-600 dark:text-rose-400 font-medium mt-1']) }}>{{ $message }}</p>
@enderror
