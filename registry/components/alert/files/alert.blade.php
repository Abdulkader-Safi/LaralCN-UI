@props([
    'variant' => 'default',
    'title' => null,
])

@php
    $base = 'relative w-full rounded-lg border border-border p-4';

    $variants = match ($variant) {
        'destructive'
            => 'border-destructive/50 text-destructive [&>svg]:text-destructive',
        default => 'bg-background text-foreground',
    };

    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        $base,
        $variants,
        $attributes->get('class'),
    );
@endphp

<div role="alert"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    @isset($icon)
        <span
            class="absolute left-4 top-4 [&>svg]:h-4 [&>svg]:w-4">{{ $icon }}</span>
        <div class="pl-7">
        @else
            <div>
            @endisset
            @if ($title)
                <h5 class="mb-1 font-medium leading-none tracking-tight">
                    {{ $title }}</h5>
            @endif
            <div class="text-sm [&_p]:leading-relaxed text-muted-foreground">
                {{ $slot }}
            </div>
        </div>
    </div>
