@props([
    'href' => '#',
    'isActive' => false,
    'size' => 'icon',
])

@php
    $base =
        'inline-flex items-center justify-center gap-1 whitespace-nowrap rounded-md text-sm font-medium outline-none transition-colors focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-disabled:pointer-events-none aria-disabled:opacity-50';

    // The current page reads as an outline button, the rest as ghost buttons.
    $state = $isActive
        ? 'border border-input bg-background shadow-xs hover:bg-accent hover:text-accent-foreground dark:bg-input/30 dark:hover:bg-input/50'
        : 'hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/50';

    $sizes = match ($size) {
        'sm' => 'h-8 px-3',
        'lg' => 'h-10 px-6',
        'md' => 'h-9 px-4 py-2',
        default => 'size-9',
    };

    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        $base,
        $state,
        $sizes,
        $attributes->get('class'),
    );
@endphp

<a href="{{ $href }}" @if ($isActive) aria-current="page" @endif
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
