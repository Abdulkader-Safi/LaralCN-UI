@php
    $icon = fn(
        string $paths,
    ): string => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5" aria-hidden="true">' .
        $paths .
        '</svg>';

    $items = [
        [
            'Page One',
            'Short description of the page goes here.',
            $icon(
                '<rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/>',
            ),
        ],
        [
            'Page Two',
            'Short description of the page goes here.',
            $icon(
                '<path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/>',
            ),
        ],
        [
            'Page Three',
            'Short description of the page goes here.',
            $icon(
                '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/>',
            ),
        ],
        [
            'Page Four',
            'Short description of the page goes here.',
            $icon(
                '<path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/>',
            ),
        ],
        [
            'Page Five',
            'Short description of the page goes here.',
            $icon(
                '<circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24"/><path d="m14.83 9.17 4.24-4.24"/><path d="m14.83 14.83 4.24 4.24"/><path d="m9.17 14.83-4.24 4.24"/><circle cx="12" cy="12" r="4"/>',
            ),
        ],
        [
            'Page Six',
            'Short description of the page goes here.',
            $icon(
                '<path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/><rect width="10" height="8" x="7" y="8" rx="1"/>',
            ),
        ],
    ];
@endphp

<div class="min-h-screen bg-background text-foreground">
    <header
        class="sticky top-0 z-40 w-full border-b border-border bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
        <div class="relative mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8"
            x-data="{ mega: false }" @mouseleave="mega = false">
            {{-- Logo --}}
            <a href="#"
                class="flex items-center gap-2 font-semibold text-foreground">
                <span
                    class="flex size-8 items-center justify-center rounded-md bg-primary text-primary-foreground">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="size-5" aria-hidden="true">
                        <path d="M12 2 2 7l10 5 10-5-10-5Z" />
                        <path d="m2 17 10 5 10-5" />
                        <path d="m2 12 10 5 10-5" />
                    </svg>
                </span>
                <span class="text-lg">Logo</span>
            </a>

            {{-- Desktop navigation --}}
            <nav class="hidden items-center gap-1 lg:flex" aria-label="Main">
                <button type="button" @mouseenter="mega = true"
                    @click="mega = !mega" x-bind:aria-expanded="mega.toString()"
                    class="inline-flex items-center gap-1 rounded-md px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground"
                    x-bind:class="mega ? 'bg-accent text-accent-foreground' : ''">
                    Features
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="size-4 transition-transform duration-200"
                        x-bind:class="mega ? 'rotate-180' : ''"
                        aria-hidden="true">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </button>
                <a href="#"
                    class="rounded-md px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground">Pricing</a>
                <a href="#"
                    class="rounded-md px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground">Docs</a>
            </nav>

            {{-- Desktop actions --}}
            <div class="hidden items-center gap-2 lg:flex">
                <x-ui.button variant="ghost" size="sm">Sign
                    in</x-ui.button>
                <x-ui.button size="sm">Get Started</x-ui.button>
            </div>

            {{-- Mega menu panel --}}
            <div x-show="mega" x-cloak @mouseenter="mega = true"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-1"
                class="absolute inset-x-4 top-full hidden justify-center pt-3 lg:flex">
                <div
                    class="grid w-full max-w-4xl grid-cols-2 gap-2 rounded-xl border border-border bg-popover p-4 text-popover-foreground shadow-lg">
                    @foreach ($items as [$title, $desc, $svg])
                        <a href="#"
                            class="flex items-start gap-3 rounded-md p-3 transition-colors hover:bg-accent">
                            <span
                                class="flex size-9 shrink-0 items-center justify-center rounded-md bg-muted text-primary">{!! $svg !!}</span>
                            <span>
                                <span
                                    class="block text-sm font-medium text-foreground">{{ $title }}</span>
                                <span
                                    class="block text-sm text-muted-foreground">{{ $desc }}</span>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Mobile menu --}}
            <div class="lg:hidden">
                <x-ui.sheet side="right">
                    <x-slot:trigger>
                        <button type="button" aria-label="Open menu"
                            class="inline-flex size-10 items-center justify-center rounded-md text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="size-5" aria-hidden="true">
                                <path d="M4 12h16" />
                                <path d="M4 6h16" />
                                <path d="M4 18h16" />
                            </svg>
                        </button>
                    </x-slot:trigger>

                    <nav class="flex flex-col gap-1 px-2 pt-2"
                        aria-label="Mobile" x-data="{ sub: false }">
                        <button type="button" @click="sub = !sub"
                            x-bind:aria-expanded="sub.toString()"
                            class="flex items-center justify-between rounded-md px-3 py-2 text-sm font-medium text-foreground hover:bg-accent hover:text-accent-foreground">
                            Features
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="size-4 transition-transform duration-200"
                                x-bind:class="sub ? 'rotate-180' : ''"
                                aria-hidden="true">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </button>
                        <div x-show="sub" x-cloak x-collapse.duration.200ms
                            class="ml-3 flex flex-col gap-1 border-l border-border pl-3">
                            @foreach ($items as [$title, $desc, $svg])
                                <a href="#"
                                    class="flex items-center gap-3 rounded-md px-3 py-2 text-sm text-muted-foreground hover:bg-accent hover:text-accent-foreground">
                                    <span
                                        class="text-primary">{!! $svg !!}</span>
                                    {{ $title }}
                                </a>
                            @endforeach
                        </div>

                        <a href="#"
                            class="rounded-md px-3 py-2 text-sm font-medium text-foreground hover:bg-accent hover:text-accent-foreground">Pricing</a>
                        <a href="#"
                            class="rounded-md px-3 py-2 text-sm font-medium text-foreground hover:bg-accent hover:text-accent-foreground">Docs</a>
                    </nav>

                    <x-slot:footer>
                        <x-ui.button variant="outline" class="w-full">Sign
                            in</x-ui.button>
                        <x-ui.button class="w-full">Get Started</x-ui.button>
                    </x-slot:footer>
                </x-ui.sheet>
            </div>
        </div>
    </header>

    {{-- Demo page content (not part of the navbar) --}}
    <main class="mx-auto max-w-6xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h1
                class="text-4xl font-bold tracking-tight text-foreground sm:text-5xl">
                Everything in a tidy grid
            </h1>
            <p class="mt-4 text-lg text-muted-foreground">
                Open "Features" to reveal a compact grid of pages, each with an
                icon and a one-line description.
            </p>
        </div>
    </main>
</div>
