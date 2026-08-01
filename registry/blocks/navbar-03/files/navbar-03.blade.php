@php
    $icon = fn(
        string $paths,
    ): string => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5" aria-hidden="true">' .
        $paths .
        '</svg>';

    $groupOne = [
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
    ];

    $groupTwo = [
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
                '<path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/>',
            ),
        ],
    ];

    $featured = [
        [
            'Article title',
            'A short standfirst that previews the article and invites the reader in.',
        ],
        [
            'Article title',
            'A short standfirst that previews the article and invites the reader in.',
        ],
    ];

    $megaGroups = [
        'Page group one' => $groupOne,
        'Page group two' => $groupTwo,
    ];
@endphp

<header
    class="sticky top-0 z-40 w-full border-b border-border bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
    <div class="group/mega relative mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8"
        data-ui-mega data-state="closed">
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
            <a href="#"
                class="rounded-md px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground">Link
                One</a>
            <a href="#"
                class="rounded-md px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground">Link
                Two</a>
            <button type="button" data-ui-mega-trigger aria-expanded="false"
                class="inline-flex items-center gap-1 rounded-md px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground group-data-[state=open]/mega:bg-accent group-data-[state=open]/mega:text-accent-foreground">
                Products
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="size-4 transition-transform duration-200 group-data-[state=open]/mega:rotate-180"
                    aria-hidden="true">
                    <path d="m6 9 6 6 6-6" />
                </svg>
            </button>
        </nav>

        {{-- Desktop actions --}}
        <div class="hidden items-center gap-2 lg:flex">
            <x-ui.button variant="ghost">Sign in</x-ui.button>
            <x-ui.button>Get Started</x-ui.button>
        </div>

        {{-- Mega menu panel --}}
        <div class="invisible absolute inset-x-4 top-full hidden -translate-y-1 justify-center pt-3 opacity-0 transition duration-150 ease-out group-data-[state=open]/mega:visible group-data-[state=open]/mega:translate-y-0 group-data-[state=open]/mega:opacity-100 lg:flex">
            <div
                class="grid w-full max-w-5xl grid-cols-3 gap-6 rounded-xl border border-border bg-popover p-6 text-popover-foreground shadow-lg">
                <div class="col-span-2 grid grid-cols-2 gap-x-6 gap-y-6">
                    @foreach ($megaGroups as $label => $items)
                        <div>
                            <p
                                class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-muted-foreground">
                                {{ $label }}</p>
                            @foreach ($items as [$title, $desc, $svg])
                                <a href="#"
                                    class="flex items-start gap-3 rounded-md p-3 transition-colors hover:bg-accent">
                                    <span
                                        class="mt-0.5 text-primary">{!! $svg !!}</span>
                                    <span>
                                        <span
                                            class="block text-sm font-medium text-foreground">{{ $title }}</span>
                                        <span
                                            class="block text-sm text-muted-foreground">{{ $desc }}</span>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <div class="rounded-lg bg-muted/50 p-5">
                    <p
                        class="pb-3 text-xs font-semibold uppercase tracking-wider text-muted-foreground">
                        From the blog</p>
                    <div class="flex flex-col gap-4">
                        @foreach ($featured as [$title, $desc])
                            <a href="#" class="group block">
                                <div
                                    class="aspect-video w-full rounded-md bg-muted">
                                </div>
                                <p
                                    class="mt-2 text-sm font-medium text-foreground group-hover:underline">
                                    {{ $title }}</p>
                                <p class="text-sm text-muted-foreground">
                                    {{ $desc }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
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

                <nav class="flex flex-col gap-1 px-2 pt-2" aria-label="Mobile">
                    <a href="#"
                        class="rounded-md px-3 py-2 text-sm font-medium text-foreground hover:bg-accent hover:text-accent-foreground">Link
                        One</a>
                    <a href="#"
                        class="rounded-md px-3 py-2 text-sm font-medium text-foreground hover:bg-accent hover:text-accent-foreground">Link
                        Two</a>

                    <x-ui.collapsible class="flex flex-col">
                        <x-ui.collapsible.trigger
                            class="flex items-center justify-between rounded-md px-3 py-2 text-sm font-medium text-foreground hover:bg-accent hover:text-accent-foreground">
                            Products
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="size-4 transition-transform duration-200 group-data-[state=open]/collapsible:rotate-180"
                                aria-hidden="true">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </x-ui.collapsible.trigger>

                        <x-ui.collapsible.content
                            class="ml-3 flex-col gap-1 border-l border-border pl-3 group-data-[state=open]/collapsible:flex">
                            @foreach ($megaGroups as $items)
                                @foreach ($items as [$title, $desc, $svg])
                                    <a href="#"
                                        class="flex items-center gap-3 rounded-md px-3 py-2 text-sm text-muted-foreground hover:bg-accent hover:text-accent-foreground">
                                        <span
                                            class="text-primary">{!! $svg !!}</span>
                                        {{ $title }}
                                    </a>
                                @endforeach
                            @endforeach
                        </x-ui.collapsible.content>
                    </x-ui.collapsible>
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

@once
    <script>
        (function() {
            // One listener set is enough even if two navbar blocks land on the
            // same page, so bail out if another block already installed it.
            if (window.__uiMegaMenu) return;
            window.__uiMegaMenu = true;

            function setState(root, open) {
                root.dataset.state = open ? 'open' : 'closed';
                root.querySelector('[data-ui-mega-trigger]')
                    .setAttribute('aria-expanded', String(open));
            }

            document.addEventListener('click', function(event) {
                var trigger = event.target.closest('[data-ui-mega-trigger]');
                if (!trigger) return;

                var root = trigger.closest('[data-ui-mega]');
                setState(root, root.dataset.state !== 'open');
            });

            // Hovering the trigger opens it; leaving the header closes it.
            document.addEventListener('mouseover', function(event) {
                document.querySelectorAll('[data-ui-mega][data-state="open"]').forEach(function(root) {
                    if (!root.contains(event.target)) setState(root, false);
                });

                var trigger = event.target.closest('[data-ui-mega-trigger]');
                if (trigger) setState(trigger.closest('[data-ui-mega]'), true);
            });

            document.addEventListener('keydown', function(event) {
                if (event.key !== 'Escape') return;

                document.querySelectorAll('[data-ui-mega][data-state="open"]').forEach(function(root) {
                    setState(root, false);
                    root.querySelector('[data-ui-mega-trigger]').focus();
                });
            });
        })();
    </script>
@endonce
