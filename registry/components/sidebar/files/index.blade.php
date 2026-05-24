@props([
    'side' => 'left',
    'collapsible' => 'icon',
])

@php
    $isIcon = $collapsible === 'icon';
    $offscreen = $side === 'right' ? 'translate-x-full' : '-translate-x-full';

    // Layout gap the sidebar reserves: full → icon width → 0 (offcanvas).
    $gapWidth =
        "state === 'expanded' ? 'var(--sidebar-width)' : " .
        ($isIcon ? "'var(--sidebar-width-icon)'" : "'0px'");

    // The fixed panel: icon mode shrinks its width; offcanvas keeps full width
    // and slides off-screen (so icon-mode tooltips are never clipped).
    $panelWidth = $isIcon
        ? "state === 'expanded' ? 'var(--sidebar-width)' : 'var(--sidebar-width-icon)'"
        : "'var(--sidebar-width)'";
    $panelSlide = $isIcon
        ? "''"
        : "state === 'collapsed' ? '{$offscreen}' : ''";
@endphp

{{-- Desktop sidebar --}}
<div class="group peer hidden text-sidebar-foreground md:block"
    x-bind:data-state="state"
    x-bind:data-collapsible="state === 'collapsed' ? '{{ $collapsible }}' : ''"
    data-side="{{ $side }}" data-variant="sidebar">
    {{-- gap handler --}}
    <div class="relative bg-transparent transition-[width] duration-200 ease-linear"
        x-bind:style="`width: ${ {{ $gapWidth }} }`"></div>
    {{-- fixed panel --}}
    <div class="fixed inset-y-0 z-10 hidden h-svh transition-[left,right,width,transform] duration-200 ease-linear md:flex {{ $side === 'right' ? 'right-0' : 'left-0' }}"
        x-bind:style="`width: ${ {{ $panelWidth }} }`"
        x-bind:class="{{ $panelSlide }}">
        <div data-sidebar="sidebar"
            class="flex h-full w-full flex-col bg-sidebar {{ $side === 'right' ? 'border-l' : 'border-r' }} border-sidebar-border">
            {{ $slot }}
        </div>
    </div>
</div>

{{-- Mobile sidebar (off-canvas sheet) --}}
<template x-if="isMobile">
    <div x-show="openMobile" x-cloak @keydown.escape.window="openMobile = false">
        <div class="fixed inset-0 z-50 bg-black/50" x-show="openMobile"
            x-transition.opacity @click="openMobile = false"></div>
        <div class="fixed inset-y-0 z-50 flex h-svh w-(--sidebar-width-mobile) flex-col bg-sidebar text-sidebar-foreground {{ $side === 'right' ? 'right-0' : 'left-0' }}"
            role="dialog" aria-modal="true" data-sidebar="sidebar" data-mobile="true"
            x-show="openMobile" x-trap.noscroll.inert="openMobile"
            x-transition:enter="transition ease-in-out duration-300"
            x-transition:enter-start="{{ $offscreen }}"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="{{ $offscreen }}">
            <div class="flex h-full w-full flex-col">
                {{ $slot }}
            </div>
        </div>
    </div>
</template>
