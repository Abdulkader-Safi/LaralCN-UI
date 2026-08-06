@props([
    'variant' => 'default',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
])

@php
    $base =
        "inline-flex shrink-0 items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium outline-none transition-all disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 [&_svg]:shrink-0 focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:border-destructive aria-invalid:ring-destructive/20";

    $variants = match ($variant) {
        'destructive'
            => 'bg-destructive text-destructive-foreground shadow-xs hover:bg-destructive/90 focus-visible:ring-destructive/20',
        'outline'
            => 'border border-input bg-background shadow-xs hover:bg-accent hover:text-accent-foreground dark:bg-input/30 dark:border-input dark:hover:bg-input/50',
        'secondary'
            => 'bg-secondary text-secondary-foreground shadow-xs hover:bg-secondary/80',
        'ghost'
            => 'hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/50',
        'link' => 'text-primary underline-offset-4 hover:underline',
        default
            => 'bg-primary text-primary-foreground shadow-xs hover:bg-primary/90',
    };

    $sizes = match ($size) {
        'sm' => 'h-8 gap-1.5 rounded-md px-3 has-[>svg]:px-2.5',
        'lg' => 'h-10 rounded-md px-6 has-[>svg]:px-4',
        'icon' => 'size-9',
        default => 'h-9 px-4 py-2 has-[>svg]:px-3',
    };

    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        $base,
        $variants,
        $sizes,
        $attributes->get('class'),
    );
@endphp

{{-- Renders an <a> when href is set, so a CMS can point a call to action somewhere. --}}
@if ($href)
    <a href="{{ $href }}"
        {{ $attributes->except('class')->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}"
        {{ $attributes->except('class')->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
