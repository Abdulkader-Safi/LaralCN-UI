@props([
    'title' => null,
    'description' => null,
])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'flex flex-col gap-6 rounded-xl border bg-card py-6 text-card-foreground shadow-sm',
        $attributes->get('class'),
    );
@endphp

<div {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    @if ($title || $description || isset($header))
        <div class="flex flex-col gap-1.5 px-6">
            @isset($header)
                {{ $header }}
            @else
                @if ($title)
                    <h3 class="font-semibold leading-none">{{ $title }}</h3>
                @endif
                @if ($description)
                    <p class="text-sm text-muted-foreground">{{ $description }}</p>
                @endif
            @endisset
        </div>
    @endif

    <div class="px-6">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="flex items-center px-6">
            {{ $footer }}
        </div>
    @endisset
</div>
