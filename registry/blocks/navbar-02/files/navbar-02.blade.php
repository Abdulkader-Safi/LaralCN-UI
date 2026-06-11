@php
    $links = ['Link One', 'Link Two', 'Link Three'];
    $dropdownLinks = ['Link Five', 'Link Six', 'Link Seven'];
@endphp

<div class="min-h-screen bg-background text-foreground">
    <header class="w-full border-b border-border bg-background">
        <div
            class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
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
                @foreach ($links as $link)
                    <a href="#"
                        class="rounded-md px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground">{{ $link }}</a>
                @endforeach

                <x-ui.dropdown-menu>
                    <x-slot:trigger>
                        <button type="button"
                            class="inline-flex items-center gap-1 rounded-md px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground"
                            x-bind:class="open ? 'bg-accent text-accent-foreground' : ''">
                            Link Four
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
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

            {{-- Desktop action --}}
            <div class="hidden lg:block">
                <x-ui.button>Get Started</x-ui.button>
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
                                stroke-linecap="round" stroke-linejoin="round"
                                class="size-4 transition-transform duration-200"
                                x-bind:class="sub ? 'rotate-180' : ''"
                                aria-hidden="true">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </button>
                        <div x-show="sub" x-cloak x-collapse.duration.200ms
                            class="ml-3 flex flex-col gap-1 border-l border-border pl-3">
                            @foreach ($dropdownLinks as $dropdownLink)
                                <a href="#"
                                    class="rounded-md px-3 py-2 text-sm text-muted-foreground hover:bg-accent hover:text-accent-foreground">{{ $dropdownLink }}</a>
                            @endforeach
                        </div>
                    </nav>

                    <x-slot:footer>
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
                A clean, minimal header
            </h1>
            <p class="mt-4 text-lg text-muted-foreground">
                Centered navigation, one dropdown, and a single primary action.
                Everything funnels to one call to action.
            </p>
            <div class="mt-8 flex items-center justify-center">
                <x-ui.button size="lg">Get Started</x-ui.button>
            </div>
        </div>
    </main>
</div>
