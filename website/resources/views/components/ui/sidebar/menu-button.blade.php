@props([
    'variant' => 'default',
    'size' => 'default',
    'isActive' => false,
    'href' => null,
    'tooltip' => null,
])

@php
    $base =
        'peer/menu-button flex w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left text-sm outline-none ring-sidebar-ring transition-[width,height,padding] hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 active:bg-sidebar-accent active:text-sidebar-accent-foreground disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 data-[active=true]:bg-sidebar-accent data-[active=true]:font-medium data-[active=true]:text-sidebar-accent-foreground group-data-[collapsible=icon]:size-8! group-data-[collapsible=icon]:p-2! [&>span:last-child]:truncate [&>svg]:size-4 [&>svg]:shrink-0';

    $variants = match ($variant) {
        'outline'
            => 'bg-background shadow-[0_0_0_1px_var(--sidebar-border)] hover:shadow-[0_0_0_1px_var(--sidebar-accent)]',
        default => '',
    };

    $sizes = match ($size) {
        'sm' => 'h-7 text-xs',
        'lg' => 'h-12 text-sm group-data-[collapsible=icon]:p-0!',
        default => 'h-8 text-sm',
    };

    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        $base,
        $variants,
        $sizes,
        $attributes->get('class'),
    );

    $tag = $href ? 'a' : 'button';
@endphp

@if ($tooltip)
    <div class="relative" x-data="{ hovered: false }"
        @mouseenter="hovered = true" @mouseleave="hovered = false">
        <{{ $tag }} data-sidebar="menu-button" data-size="{{ $size }}"
            data-active="{{ $isActive ? 'true' : 'false' }}"
            @if ($href) href="{{ $href }}" @else type="button" @endif
            {{ $attributes->except('class')->merge(['class' => $classes]) }}>
            {{ $slot }}
        </{{ $tag }}>
        <span role="tooltip" x-cloak
            x-show="hovered && state === 'collapsed' && !isMobile"
            x-transition
            class="absolute left-full top-1/2 z-50 ml-2 w-fit -translate-y-1/2 whitespace-nowrap rounded-md bg-primary px-3 py-1.5 text-xs text-primary-foreground">
            {{ $tooltip }}
        </span>
    </div>
@else
    <{{ $tag }} data-sidebar="menu-button" data-size="{{ $size }}"
        data-active="{{ $isActive ? 'true' : 'false' }}"
        @if ($href) href="{{ $href }}" @else type="button" @endif
        {{ $attributes->except('class')->merge(['class' => $classes]) }}>
        {{ $slot }}
    </{{ $tag }}>
@endif
