@aware([
    'multiple' => false,
    'name' => 'toggle-group',
    'variant' => 'default',
    'size' => 'md',
])

@props([
    'value' => null,
    'pressed' => false,
])

@php
    // Single-select is a radio group, multi-select a set of checkboxes. Either
    // way the browser owns the state, so there is no script: radios even give
    // arrow-key navigation between items for free.
    $base =
        "relative inline-flex cursor-pointer items-center justify-center gap-2 whitespace-nowrap rounded-none text-sm font-medium transition-colors first:rounded-l-md last:rounded-r-md has-[:checked]:z-10 has-[:checked]:bg-accent has-[:checked]:text-accent-foreground has-[:focus-visible]:z-10 has-[:focus-visible]:border-ring has-[:focus-visible]:ring-ring/50 has-[:focus-visible]:ring-[3px] has-[:disabled]:pointer-events-none has-[:disabled]:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 [&_svg]:shrink-0";

    // Same reasoning as the toggle component: scoping the hover with
    // :not(:has(:checked)) stops it repainting the pressed background, which a
    // plain hover: would do or not do depending on emitted rule order.
    $hover =
        '[&:not(:has(:checked))]:hover:bg-muted [&:not(:has(:checked))]:hover:text-muted-foreground';

    $variants = match ($variant) {
        'outline' => 'border border-input bg-transparent -ml-px first:ml-0',
        default => 'bg-transparent',
    };

    $sizes = match ($size) {
        'sm' => 'h-8 min-w-8 px-1.5',
        'lg' => 'h-10 min-w-10 px-2.5',
        default => 'h-9 min-w-9 px-2',
    };

    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        $base,
        $hover,
        $variants,
        $sizes,
        $attributes->get('class'),
    );
@endphp

<label {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    <input type="{{ $multiple ? 'checkbox' : 'radio' }}"
        name="{{ $multiple ? $name . '[]' : $name }}" value="{{ $value }}"
        class="peer sr-only" @checked($pressed) />
    {{ $slot }}
</label>
