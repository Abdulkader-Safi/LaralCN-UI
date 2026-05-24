@props([
    'variant' => 'default',
    'title' => null,
])

@php
    $base =
        "relative grid w-full grid-cols-[0_1fr] items-start gap-y-0.5 rounded-lg border px-4 py-3 text-sm has-[>svg]:grid-cols-[calc(var(--spacing)*4)_1fr] has-[>svg]:gap-x-3 [&>svg]:size-4 [&>svg]:translate-y-0.5 [&>svg]:text-current";

    $variants = match ($variant) {
        'destructive'
            => 'bg-card text-destructive [&>svg]:text-current',
        default => 'bg-card text-card-foreground',
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
        {{ $icon }}
    @endisset
    @if ($title)
        <div class="col-start-2 line-clamp-1 min-h-4 font-medium tracking-tight">
            {{ $title }}
        </div>
    @endif
    <div
        class="col-start-2 grid justify-items-start gap-1 text-sm {{ $variant === 'destructive' ? 'text-destructive/90' : 'text-muted-foreground' }} [&_p]:leading-relaxed">
        {{ $slot }}
    </div>
</div>
