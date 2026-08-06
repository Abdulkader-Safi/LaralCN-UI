@props([
    'href' => '#',
    'label' => 'Next',
])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'inline-flex h-9 items-center justify-center gap-1 whitespace-nowrap rounded-md px-2.5 text-sm font-medium outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-disabled:pointer-events-none aria-disabled:opacity-50 dark:hover:bg-accent/50',
        $attributes->get('class'),
    );
@endphp

<a href="{{ $href }}" aria-label="Go to next page"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    <span class="hidden sm:block">{{ $slot->isNotEmpty() ? $slot : $label }}</span>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="2" stroke-linecap="round"
        stroke-linejoin="round" class="size-4" aria-hidden="true">
        <path d="m9 18 6-6-6-6" />
    </svg>
</a>
