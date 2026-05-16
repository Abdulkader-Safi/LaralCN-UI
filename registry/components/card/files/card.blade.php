@props([
    'title' => null,
    'description' => null,
])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'rounded-lg border border-border bg-card text-card-foreground shadow-sm',
        $attributes->get('class'),
    );
@endphp

<div {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    @if ($title || $description || isset($header))
        <div class="flex flex-col gap-1.5 p-6">
            @isset($header)
                {{ $header }}
            @else
                @if ($title)
                    <h3 class="text-2xl font-semibold leading-none tracking-tight">
                        {{ $title }}</h3>
                @endif
                @if ($description)
                    <p class="text-sm text-muted-foreground">{{ $description }}</p>
                @endif
            @endisset
        </div>
    @endif

    <div class="p-6 pt-0">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="flex items-center p-6 pt-0">
            {{ $footer }}
        </div>
    @endisset
</div>
