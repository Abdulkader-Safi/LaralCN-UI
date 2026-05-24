@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'peer size-4 shrink-0 rounded-[4px] border border-input bg-transparent accent-primary shadow-xs outline-none transition-shadow disabled:cursor-not-allowed disabled:opacity-50 dark:bg-input/30 focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:border-destructive aria-invalid:ring-destructive/20',
        $attributes->get('class'),
    );
@endphp

<input type="checkbox"
    {{ $attributes->except('class')->merge(['class' => $classes]) }} />
