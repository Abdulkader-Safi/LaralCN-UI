@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        '[&>svg]:size-3.5',
        $attributes->get('class'),
    );
@endphp

<li role="presentation" aria-hidden="true"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    @if ($slot->isNotEmpty())
        {{ $slot }}
    @else
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" aria-hidden="true">
            <path d="m9 18 6-6-6-6" />
        </svg>
    @endif
</li>
