@props([
    'size' => 'md',
    'isActive' => false,
    'href' => null,
])

@php
    $sizes = match ($size) {
        'sm' => 'text-xs',
        default => 'text-sm',
    };

    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'flex h-7 min-w-0 -translate-x-px items-center gap-2 overflow-hidden rounded-md px-2 text-sidebar-foreground outline-none ring-sidebar-ring transition-[width,height,padding] hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 active:bg-sidebar-accent active:text-sidebar-accent-foreground disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 data-[active=true]:bg-sidebar-accent data-[active=true]:text-sidebar-accent-foreground [&>span:last-child]:truncate [&>svg]:size-4 [&>svg]:shrink-0 [&>svg]:text-sidebar-accent-foreground group-data-[collapsible=icon]:hidden',
        $sizes,
        $attributes->get('class'),
    );

    $tag = $href ? 'a' : 'button';
@endphp

<{{ $tag }} data-sidebar="menu-sub-button" data-size="{{ $size }}"
    data-active="{{ $isActive ? 'true' : 'false' }}"
    @if ($href) href="{{ $href }}" @else type="button" @endif
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</{{ $tag }}>
