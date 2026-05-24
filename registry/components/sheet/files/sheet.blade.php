@props([
    'side' => 'right',
    'title' => null,
    'description' => null,
])

@php
    // shadcn SheetContent per-side positioning, size and border.
    $sideClasses = match ($side) {
        'top' => 'inset-x-0 top-0 h-auto border-b',
        'bottom' => 'inset-x-0 bottom-0 h-auto border-t',
        'left' => 'inset-y-0 left-0 h-full w-3/4 border-r sm:max-w-sm',
        default => 'inset-y-0 right-0 h-full w-3/4 border-l sm:max-w-sm',
    };

    // Off-screen transform for the slide (Alpine replaces tailwindcss-animate).
    $offscreen = match ($side) {
        'top' => '-translate-y-full',
        'bottom' => 'translate-y-full',
        'left' => '-translate-x-full',
        default => 'translate-x-full',
    };

    $overlay = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'fixed inset-0 z-50 bg-black/50',
    );

    $panel = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'fixed z-50 flex flex-col gap-4 bg-background shadow-lg',
        $sideClasses,
        $attributes->get('class'),
    );
@endphp

<div x-data="{ open: false }" @keydown.escape.window="open = false"
    {{ $attributes->except('class') }}>
    <div @click="open = true">
        {{ $trigger }}
    </div>

    <template x-teleport="body">
        <div x-show="open" x-cloak>
            <div class="{{ $overlay }}" x-show="open" x-transition.opacity
                @click="open = false"></div>

            <div class="{{ $panel }}" role="dialog" aria-modal="true"
                @if ($title) aria-labelledby="sheet-title" @endif
                @if ($description) aria-describedby="sheet-description" @endif
                x-show="open" x-trap.noscroll.inert="open"
                x-transition:enter="transition ease-in-out duration-300"
                x-transition:enter-start="{{ $offscreen }}"
                x-transition:enter-end="translate-x-0 translate-y-0"
                x-transition:leave="transition ease-in-out duration-300"
                x-transition:leave-start="translate-x-0 translate-y-0"
                x-transition:leave-end="{{ $offscreen }}">
                @if ($title || $description)
                    <div class="flex flex-col gap-1.5 p-4">
                        @if ($title)
                            <h2 id="sheet-title" class="font-semibold text-foreground">
                                {{ $title }}
                            </h2>
                        @endif
                        @if ($description)
                            <p id="sheet-description"
                                class="text-sm text-muted-foreground">
                                {{ $description }}
                            </p>
                        @endif
                    </div>
                @endif

                {{ $slot }}

                @isset($footer)
                    <div class="mt-auto flex flex-col gap-2 p-4">
                        {{ $footer }}
                    </div>
                @endisset

                <button type="button"
                    class="absolute right-4 top-4 rounded-xs opacity-70 outline-none transition-opacity hover:opacity-100 focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] disabled:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0"
                    aria-label="Close" @click="open = false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" aria-hidden="true">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </template>
</div>
