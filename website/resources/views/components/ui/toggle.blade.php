@props([
    'variant' => 'default',
    'size' => 'md',
    'name' => null,
    'value' => '1',
    'pressed' => false,
])

@php
    // A native checkbox carries the pressed state: it submits with the form,
    // answers the spacebar and exposes checkedness to assistive tech, so this
    // component needs no script and no aria-pressed bookkeeping.
    $base =
        "inline-flex cursor-pointer items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors has-[:checked]:bg-accent has-[:checked]:text-accent-foreground has-[:focus-visible]:border-ring has-[:focus-visible]:ring-ring/50 has-[:focus-visible]:ring-[3px] has-[:disabled]:pointer-events-none has-[:disabled]:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 [&_svg]:shrink-0";

    // Scoped with :not(:has(:checked)) rather than a plain hover: so the
    // pressed background cannot be repainted on hover. Both rules would
    // otherwise have equal specificity and the winner would come down to the
    // order Tailwind happens to emit them in.
    $hover =
        '[&:not(:has(:checked))]:hover:bg-muted [&:not(:has(:checked))]:hover:text-muted-foreground';

    $variants = match ($variant) {
        'outline'
            => 'border border-input bg-transparent shadow-xs hover:bg-accent hover:text-accent-foreground',
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
    <input type="checkbox" class="peer sr-only"
        @if ($name) name="{{ $name }}" @endif value="{{ $value }}"
        @checked($pressed) />
    {{ $slot }}
</label>
