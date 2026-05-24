@props([
    'showIcon' => false,
])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'flex h-8 items-center gap-2 rounded-md px-2',
        $attributes->get('class'),
    );
@endphp

<div data-sidebar="menu-skeleton"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    @if ($showIcon)
        <div class="size-4 shrink-0 animate-pulse rounded-md bg-accent"
            data-sidebar="menu-skeleton-icon"></div>
    @endif
    <div class="h-4 max-w-(--skeleton-width) flex-1 animate-pulse rounded-md bg-accent"
        data-sidebar="menu-skeleton-text"
        style="--skeleton-width: {{ random_int(50, 90) }}%"></div>
</div>
