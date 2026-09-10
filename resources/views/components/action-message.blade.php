@props(['on'])

<div x-data="{ shown: false, timeout: null }"
    x-init="@this.on('{{ $on }}', () => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 2000); })"
    x-show.transition.out.opacity.duration.1500ms="shown"
    x-transition:leave.opacity.duration.1500ms
    style="display: none;"
    {{ $attributes->merge(['class' => 'text-sm font-medium text-emerald-600 dark:text-emerald-400 flex items-center gap-1']) }}>
    <i class="fa-solid fa-check text-xs"></i> {{ $slot->isEmpty() ? 'Saved.' : $slot }}
</div>
