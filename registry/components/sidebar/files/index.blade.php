@props([
    'side' => 'left',
    'collapsible' => 'icon',
])

@php
    $isIcon = $collapsible === 'icon';
    $offscreen = $side === 'right' ? 'translate-x-full' : '-translate-x-full';

    // Layout gap the sidebar reserves: full → icon width → 0 (offcanvas).
    $gapWidth = $isIcon
        ? 'w-(--sidebar-width) group-data-[state=collapsed]:w-(--sidebar-width-icon)'
        : 'w-(--sidebar-width) group-data-[state=collapsed]:w-0';

    // The fixed panel: icon mode shrinks its width; offcanvas keeps full width
    // and slides off-screen (so icon-mode tooltips are never clipped).
    // Every variant class below is written out in full: Tailwind scans source
    // text, so a class assembled by interpolation never gets compiled.
    $panelWidth = match (true) {
        $isIcon => 'w-(--sidebar-width) group-data-[state=collapsed]:w-(--sidebar-width-icon)',
        $side === 'right' => 'w-(--sidebar-width) group-data-[state=collapsed]:translate-x-full',
        default => 'w-(--sidebar-width) group-data-[state=collapsed]:-translate-x-full',
    };
@endphp

{{-- Desktop sidebar. data-state / data-collapsible are kept in sync by the
     script that ships with <x-ui.sidebar.provider>. --}}
<div class="group peer hidden text-sidebar-foreground md:block" data-ui-sidebar
    data-mode="{{ $collapsible }}" data-state="expanded" data-collapsible=""
    data-side="{{ $side }}" data-variant="sidebar">
    {{-- gap handler --}}
    <div
        class="relative bg-transparent transition-[width] duration-200 ease-linear {{ $gapWidth }}">
    </div>
    {{-- fixed panel --}}
    <div class="fixed inset-y-0 z-10 hidden h-svh transition-[left,right,width,transform] duration-200 ease-linear md:flex {{ $side === 'right' ? 'right-0' : 'left-0' }} {{ $panelWidth }}"
        data-sidebar="sidebar">
        <div
            class="flex h-full w-full flex-col bg-sidebar {{ $side === 'right' ? 'border-l' : 'border-r' }} border-sidebar-border">
            {{ $slot }}
        </div>
    </div>
</div>

{{-- Mobile sidebar: a native <dialog>, so it lands in the top layer with a
     focus trap and Esc handling already wired. --}}
<dialog data-ui-sidebar-mobile data-state="closed"
    class="group/mobile m-0 h-full max-h-none w-full max-w-none bg-transparent p-0 backdrop:bg-transparent md:hidden">
    {{-- Not bg-black/50. Tailwind v4 compiles that to oklab(0 0 0 / 0.5), and
         Chrome does not paint a modern colour function with alpha inside the
         dialog top layer, so the scrim silently renders as nothing. A legacy
         rgb() with alpha composites correctly in the same place. --}}
    <div class="absolute inset-0 bg-[rgb(0_0_0/0.5)] opacity-0 transition-opacity duration-300 group-data-[state=open]/mobile:opacity-100"
        data-ui-sidebar-mobile-close></div>

    <div class="absolute inset-y-0 flex h-svh w-(--sidebar-width-mobile) flex-col bg-sidebar text-sidebar-foreground transition-transform duration-300 ease-in-out {{ $side === 'right' ? 'right-0' : 'left-0' }} {{ $offscreen }} group-data-[state=open]/mobile:translate-x-0"
        data-sidebar="sidebar" data-mobile="true">
        <div class="flex h-full w-full flex-col">
            {{ $slot }}
        </div>
    </div>
</dialog>
