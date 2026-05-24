@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'flex select-none items-center gap-2 text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-50 group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50',
        $attributes->get('class'),
    );
@endphp

<label {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</label>
