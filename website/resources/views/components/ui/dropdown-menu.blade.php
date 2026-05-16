@props([
    'align' => 'start',
])

@php
    $alignment = match ($align) {
        'end' => 'right-0 origin-top-right',
        'center' => 'left-1/2 -translate-x-1/2 origin-top',
        default => 'left-0 origin-top-left',
    };

    $menuClasses = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'absolute z-50 mt-2 min-w-[8rem] overflow-hidden rounded-md border border-border bg-popover p-1 text-popover-foreground shadow-md',
        $alignment,
        $attributes->get('class'),
    );
@endphp

<div class="relative inline-block text-left" x-data="{ open: false }"
    @keydown.escape.window="open = false" @click.outside="open = false">
    <div @click="open = !open" x-bind:aria-expanded="open.toString()"
        aria-haspopup="menu">
        {{ $trigger }}
    </div>

    <div x-show="open" x-cloak x-transition role="menu"
        class="{{ $menuClasses }}">
        {{ $slot }}
    </div>
</div>
