@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'h-4 w-4 shrink-0 border border-primary text-primary accent-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50',
        $attributes->get('class'),
    );
@endphp

<input type="radio"
    {{ $attributes->except('class')->merge(['class' => $classes]) }} />
