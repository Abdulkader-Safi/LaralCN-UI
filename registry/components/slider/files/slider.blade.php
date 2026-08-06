@props([
    'name' => null,
    'min' => 0,
    'max' => 100,
    'step' => 1,
    'value' => 50,
])

@php
    // A native range input: keyboard (arrows, Home/End), form submission and
    // the drag interaction are all the platform's job, so this ships no script.
    // The cost is that the track and thumb are vendor pseudo-elements, and
    // WebKit and Firefox each need their own rules. Both sets below are
    // required; dropping one leaves the slider unstyled in that browser.
    $base =
        'h-4 w-full cursor-pointer appearance-none bg-transparent outline-none disabled:pointer-events-none disabled:opacity-50';

    $webkit =
        '[&::-webkit-slider-runnable-track]:h-1.5 [&::-webkit-slider-runnable-track]:w-full [&::-webkit-slider-runnable-track]:rounded-full [&::-webkit-slider-runnable-track]:bg-primary/20 [&::-webkit-slider-thumb]:-mt-[5px] [&::-webkit-slider-thumb]:size-4 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:border [&::-webkit-slider-thumb]:border-primary [&::-webkit-slider-thumb]:bg-background [&::-webkit-slider-thumb]:shadow-sm [&::-webkit-slider-thumb]:transition-[box-shadow] focus-visible:[&::-webkit-slider-thumb]:ring-[3px] focus-visible:[&::-webkit-slider-thumb]:ring-ring/50';

    $firefox =
        '[&::-moz-range-track]:h-1.5 [&::-moz-range-track]:w-full [&::-moz-range-track]:rounded-full [&::-moz-range-track]:bg-primary/20 [&::-moz-range-thumb]:size-4 [&::-moz-range-thumb]:appearance-none [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:border [&::-moz-range-thumb]:border-primary [&::-moz-range-thumb]:bg-background [&::-moz-range-thumb]:shadow-sm focus-visible:[&::-moz-range-thumb]:ring-[3px] focus-visible:[&::-moz-range-thumb]:ring-ring/50';

    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        $base,
        $webkit,
        $firefox,
        $attributes->get('class'),
    );
@endphp

<input type="range" @if ($name) name="{{ $name }}" @endif
    min="{{ $min }}" max="{{ $max }}" step="{{ $step }}"
    value="{{ $value }}"
    {{ $attributes->except('class')->merge(['class' => $classes]) }} />
