@props([
    'variant' => 'default',
])

@php
    $base =
        'inline-flex w-fit shrink-0 items-center justify-center gap-1 overflow-hidden whitespace-nowrap rounded-md border px-2 py-0.5 text-xs font-medium transition-[color,box-shadow] [&>svg]:pointer-events-none [&>svg]:size-3 focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:border-destructive aria-invalid:ring-destructive/20';

    $variants = match ($variant) {
        'secondary'
            => 'border-transparent bg-secondary text-secondary-foreground [a&]:hover:bg-secondary/90',
        'destructive'
            => 'border-transparent bg-destructive text-destructive-foreground [a&]:hover:bg-destructive/90 focus-visible:ring-destructive/20',
        'outline'
            => 'text-foreground [a&]:hover:bg-accent [a&]:hover:text-accent-foreground',
        default
            => 'border-transparent bg-primary text-primary-foreground [a&]:hover:bg-primary/90',
    };

    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        $base,
        $variants,
        $attributes->get('class'),
    );
@endphp

<span {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
