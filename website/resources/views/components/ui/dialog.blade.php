@props([
    'title' => null,
    'description' => null,
])

@php
    $overlay = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'fixed inset-0 z-50 bg-black/80',
    );

    $panel = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'fixed left-1/2 top-1/2 z-50 grid w-full max-w-lg -translate-x-1/2 -translate-y-1/2 gap-4 border border-border bg-background p-6 shadow-lg sm:rounded-lg',
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
                @if ($title) aria-labelledby="dialog-title" @endif
                @if ($description) aria-describedby="dialog-description" @endif
                x-show="open" x-transition x-trap.noscroll.inert="open">
                @if ($title || $description)
                    <div class="flex flex-col gap-1.5 text-center sm:text-left">
                        @if ($title)
                            <h2 id="dialog-title"
                                class="text-lg font-semibold leading-none tracking-tight">
                                {{ $title }}
                            </h2>
                        @endif
                        @if ($description)
                            <p id="dialog-description"
                                class="text-sm text-muted-foreground">
                                {{ $description }}
                            </p>
                        @endif
                    </div>
                @endif

                {{ $slot }}

                @isset($footer)
                    <div
                        class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                        {{ $footer }}
                    </div>
                @endisset

                <button type="button"
                    class="absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
                    aria-label="Close" @click="open = false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        aria-hidden="true">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </template>
</div>
