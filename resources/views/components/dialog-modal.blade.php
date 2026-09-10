@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-5 bg-white dark:bg-slate-900">
        <div class="text-lg font-bold font-display text-slate-900 dark:text-slate-100">
            {{ $title }}
        </div>

        <div class="mt-4 text-sm text-slate-600 dark:text-slate-400">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 bg-slate-50 dark:bg-slate-800/80 border-t border-slate-100 dark:border-slate-700 text-end">
        {{ $footer }}
    </div>
</x-modal>
