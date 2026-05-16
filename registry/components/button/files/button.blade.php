@props([
    'variant' => 'default',
    'size' => 'md',
    'type' => 'button',
])

@php
    $base =
        'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50';

    $variants = match ($variant) {
        'destructive'
            => 'bg-destructive text-destructive-foreground hover:bg-destructive/90',
        'outline'
            => 'border border-input bg-background hover:bg-accent hover:text-accent-foreground',
        'secondary'
            => 'bg-secondary text-secondary-foreground hover:bg-secondary/80',
        'ghost' => 'hover:bg-accent hover:text-accent-foreground',
        'link' => 'text-primary underline-offset-4 hover:underline',
        default => 'bg-primary text-primary-foreground hover:bg-primary/90',
    };

    $sizes = match ($size) {
        'sm' => 'h-9 px-3',
        'lg' => 'h-11 px-8',
        'icon' => 'h-10 w-10',
        default => 'h-10 px-4 py-2',
    };

    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        $base,
        $variants,
        $sizes,
        $attributes->get('class'),
    );
@endphp

<button type="{{ $type }}"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
