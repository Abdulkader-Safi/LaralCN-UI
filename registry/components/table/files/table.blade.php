@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'w-full caption-bottom text-sm',
        $attributes->get('class'),
    );
@endphp

<div class="relative w-full overflow-auto">
    <table {{ $attributes->except('class')->merge(['class' => $classes]) }}>
        {{ $slot }}
    </table>
</div>
