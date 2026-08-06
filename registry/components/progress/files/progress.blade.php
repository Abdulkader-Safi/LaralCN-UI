@props([
    'value' => 0,
    'max' => 100,
])

@php
    // Guard the divisor: a max of 0 from a caller's arithmetic would blow up.
    $ceiling = max(1, (int) $max);
    $current = max(0, min($ceiling, (float) $value));
    // Rounded so the style attribute does not carry 33.333333333333336%.
    $remaining = round(100 - ($current / $ceiling) * 100, 2);

    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'relative h-2 w-full overflow-hidden rounded-full bg-primary/20',
        $attributes->get('class'),
    );
@endphp

<div role="progressbar" aria-valuenow="{{ $current }}" aria-valuemin="0"
    aria-valuemax="{{ $ceiling }}"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{-- The fill is positioned by transform, not width, so it animates on the
         compositor. A dynamic width has to be an inline style either way:
         w-[{{ '$percent' }}%] never reaches Tailwind's class scanner. --}}
    <div class="h-full w-full flex-1 bg-primary transition-transform duration-300 ease-out"
        style="transform: translateX(-{{ $remaining }}%)"></div>
</div>
