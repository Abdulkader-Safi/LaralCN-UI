@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'absolute right-1 top-1.5 flex aspect-square w-5 items-center justify-center rounded-md p-0 text-sidebar-foreground outline-none ring-sidebar-ring transition-transform hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 peer-hover/menu-button:text-sidebar-accent-foreground [&>svg]:size-4 [&>svg]:shrink-0 group-data-[collapsible=icon]:hidden',
        $attributes->get('class'),
    );
@endphp

<button type="button" data-sidebar="menu-action"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
