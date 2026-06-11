@php
    $links = ['Link One', 'Link Two', 'Link Three'];
    $dropdownLinks = ['Link Five', 'Link Six', 'Link Seven'];
@endphp

<div class="min-h-screen bg-background text-foreground">
    {{-- Floating header: detaches from the top edge --}}
    <div class="sticky top-0 z-40">
        <div class="mx-auto max-w-5xl px-4 pt-4 sm:px-6">
            <header
                class="flex h-14 items-center justify-between gap-4 rounded-full border border-border bg-background/80 px-3 pl-5 shadow-lg backdrop-blur supports-[backdrop-filter]:bg-background/70">
                {{-- Logo --}}
                <a href="#"
                    class="flex items-center gap-2 font-semibold text-foreground">
                    <span
                        class="flex size-7 items-center justify-center rounded-full bg-primary text-primary-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="size-4" aria-hidden="true">
                            <path d="M12 2 2 7l10 5 10-5-10-5Z" />
                            <path d="m2 17 10 5 10-5" />
                            <path d="m2 12 10 5 10-5" />
                        </svg>
                    </span>
                    <span>Logo</span>
                </a>

                {{-- Desktop navigation --}}
                <nav class="hidden items-center gap-1 lg:flex"
                    aria-label="Main">
                    @foreach ($links as $link)
                        <a href="#"
                            class="rounded-full px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground">{{ $link }}</a>
                    @endforeach

                    <x-ui.dropdown-menu align="center">
                        <x-slot:trigger>
                            <button type="button"
                                class="inline-flex items-center gap-1 rounded-full px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground"
                                x-bind:class="open ? 'bg-accent text-accent-foreground' : ''">
                                Link Four
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="size-4 transition-transform duration-200"
                                    x-bind:class="open ? 'rotate-180' : ''"
                                    aria-hidden="true">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>
                        </x-slot:trigger>

                        @foreach ($dropdownLinks as $dropdownLink)
                            <a href="#" role="menuitem"
                                class="block rounded-sm px-2 py-1.5 text-sm text-popover-foreground hover:bg-accent hover:text-accent-foreground">{{ $dropdownLink }}</a>
                        @endforeach
                    </x-ui.dropdown-menu>
                </nav>

                {{-- Desktop actions --}}
                <div class="hidden items-center gap-2 lg:flex">
                    <x-ui.button variant="ghost" size="sm"
                        class="rounded-full">Sign in</x-ui.button>
                    <x-ui.button size="sm" class="rounded-full">Get
                        Started</x-ui.button>
                </div>

                {{-- Mobile menu --}}
                <div class="lg:hidden">
                    <x-ui.sheet side="top">
                        <x-slot:trigger>
                            <button type="button" aria-label="Open menu"
                                class="inline-flex size-9 items-center justify-center rounded-full text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round" class="size-5"
                                    aria-hidden="true">
                                    <path d="M4 12h16" />
                                    <path d="M4 6h16" />
                                    <path d="M4 18h16" />
                                </svg>
                            </button>
                        </x-slot:trigger>

                        <nav class="flex flex-col gap-1 px-2 pt-6"
                            aria-label="Mobile" x-data="{ sub: false }">
                            @foreach ($links as $link)
                                <a href="#"
                                    class="rounded-md px-3 py-2 text-sm font-medium text-foreground hover:bg-accent hover:text-accent-foreground">{{ $link }}</a>
                            @endforeach

                            <button type="button" @click="sub = !sub"
                                x-bind:aria-expanded="sub.toString()"
                                class="flex items-center justify-between rounded-md px-3 py-2 text-sm font-medium text-foreground hover:bg-accent hover:text-accent-foreground">
                                Link Four
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="size-4 transition-transform duration-200"
                                    x-bind:class="sub ? 'rotate-180' : ''"
                                    aria-hidden="true">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>
                            <div x-show="sub" x-cloak
                                x-collapse.duration.200ms
                                class="ml-3 flex flex-col gap-1 border-l border-border pl-3">
                                @foreach ($dropdownLinks as $dropdownLink)
                                    <a href="#"
                                        class="rounded-md px-3 py-2 text-sm text-muted-foreground hover:bg-accent hover:text-accent-foreground">{{ $dropdownLink }}</a>
                                @endforeach
                            </div>

                            <div class="mt-3 flex flex-col gap-2 px-1">
                                <x-ui.button variant="outline"
                                    class="w-full">Sign in</x-ui.button>
                                <x-ui.button class="w-full">Get
                                    Started</x-ui.button>
                            </div>
                        </nav>
                    </x-ui.sheet>
                </div>
            </header>
        </div>
    </div>

    {{-- Demo page content (not part of the navbar) --}}
    <main class="mx-auto max-w-5xl px-4 py-20 sm:px-6">
        <div class="mx-auto max-w-2xl text-center">
            <h1
                class="text-4xl font-bold tracking-tight text-foreground sm:text-5xl">
                A header that floats
            </h1>
            <p class="mt-4 text-lg text-muted-foreground">
                A pill-shaped bar that lifts off the top edge and stays pinned
                as
                you scroll, with a frosted backdrop.
            </p>
            <div class="mt-8 flex items-center justify-center gap-3">
                <x-ui.button size="lg" class="rounded-full">Get
                    Started</x-ui.button>
                <x-ui.button size="lg" variant="outline"
                    class="rounded-full">Documentation</x-ui.button>
            </div>
        </div>
    </main>
</div>
