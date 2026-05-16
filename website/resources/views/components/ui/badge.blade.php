@props([
    'variant' => 'default',
])

@php
    $base =
        'inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2';

    $variants = match ($variant) {
        'secondary'
            => 'border-transparent bg-secondary text-secondary-foreground',
        'destructive'
            => 'border-transparent bg-destructive text-destructive-foreground',
        'outline' => 'text-foreground',
        default => 'border-transparent bg-primary text-primary-foreground',
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
