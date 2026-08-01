@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'outline-none focus-visible:ring-ring/50 focus-visible:ring-[3px]',
        $attributes->get('class'),
    );
@endphp

{{-- aria-expanded is seeded from the parent's data-state on load, then kept in
     sync by the script that ships with <x-ui.collapsible>. --}}
<button type="button" data-ui-collapsible-trigger
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
