<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'LaralCN-UI' }}, LaralCN-UI</title>
    <meta name="description"
        content="A shadcn-style copy-and-own Blade component system for Laravel.">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="LaralCN-UI">
    <meta property="og:title" content="{{ $title ?? 'LaralCN-UI' }}, LaralCN-UI">
    <meta property="og:description"
        content="A shadcn-style copy-and-own Blade component system for Laravel.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ url('og-image.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt"
        content="Plate I: the twenty-five LaralCN-UI primitives drawn as specimens.">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? 'LaralCN-UI' }}, LaralCN-UI">
    <meta name="twitter:description"
        content="A shadcn-style copy-and-own Blade component system for Laravel.">
    <meta name="twitter:image" content="{{ url('og-image.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://u.abdulkadersafi.com/script.js"
        data-website-id="759e2030-fd85-4a3c-91c7-59f411fa5698"></script>
</head>

<body class="bg-background text-foreground antialiased">
    @php
        $navLinks = [
            [
                'route' => 'docs.getting-started',
                'label' => 'Getting Started',
                'match' => 'docs.getting-started',
            ],
            [
                'route' => 'docs.index',
                'label' => 'Components',
                'match' => 'docs.index',
            ],
            [
                'route' => 'blocks.index',
                'label' => 'Blocks',
                'match' => 'blocks.*',
            ],
            [
                'route' => 'docs.theming',
                'label' => 'Theming',
                'match' => 'docs.theming',
            ],
            [
                'route' => 'docs.plain-blade',
                'label' => 'Plain Blade',
                'match' => 'docs.plain-blade',
            ],
        ];
    @endphp

    <x-ui.sidebar.provider>
        <x-ui.sidebar collapsible="offcanvas">
            {{-- Brand --}}
            <x-ui.sidebar.header>
                <x-ui.sidebar.menu>
                    <x-ui.sidebar.menu-item>
                        <x-ui.sidebar.menu-button size="lg"
                            href="{{ route('home') }}">
                            <div
                                class="flex aspect-square size-8 items-center justify-center rounded-lg bg-sidebar-primary text-sm font-bold text-sidebar-primary-foreground">
                                LC
                            </div>
                            <div
                                class="grid flex-1 text-left text-sm leading-tight">
                                <span
                                    class="truncate font-semibold">LaralCN-UI</span>
                                <span
                                    class="truncate text-xs text-muted-foreground">
                                    copy-and-own
                                </span>
                            </div>
                        </x-ui.sidebar.menu-button>
                    </x-ui.sidebar.menu-item>
                </x-ui.sidebar.menu>
            </x-ui.sidebar.header>

            <x-ui.sidebar.content>
                {{-- Guides --}}
                <x-ui.sidebar.group>
                    <x-ui.sidebar.group-label>Guides</x-ui.sidebar.group-label>
                    <x-ui.sidebar.menu>
                        @foreach ($navLinks as $link)
                            <x-ui.sidebar.menu-item>
                                <x-ui.sidebar.menu-button :href="route($link['route'])"
                                    :tooltip="$link['label']" :is-active="request()->routeIs(
                                        $link['match'],
                                    )">
                                    <span>{{ $link['label'] }}</span>
                                </x-ui.sidebar.menu-button>
                            </x-ui.sidebar.menu-item>
                        @endforeach
                    </x-ui.sidebar.menu>
                </x-ui.sidebar.group>

                {{-- Components by category --}}
                @foreach ($all ?? [] as $category => $items)
                    <x-ui.sidebar.group>
                        <x-ui.sidebar.group-label>{{ $category }}</x-ui.sidebar.group-label>
                        <x-ui.sidebar.menu>
                            @foreach ($items as $item)
                                <x-ui.sidebar.menu-item>
                                    <x-ui.sidebar.menu-button :href="route(
                                        'docs.show',
                                        $item['name'],
                                    )"
                                        :tooltip="$item['name']" :is-active="isset($entry) &&
                                            ($entry['type'] ?? null) !== 'block' &&
                                            $entry['name'] === $item['name']">
                                        <span>{{ $item['name'] }}</span>
                                    </x-ui.sidebar.menu-button>
                                </x-ui.sidebar.menu-item>
                            @endforeach
                        </x-ui.sidebar.menu>
                    </x-ui.sidebar.group>
                @endforeach
            </x-ui.sidebar.content>

            {{-- Footer --}}
            <x-ui.sidebar.footer>
                <x-ui.sidebar.menu>
                    <x-ui.sidebar.menu-item>
                        <x-ui.sidebar.menu-button tooltip="GitHub"
                            href="https://github.com/Abdulkader-Safi/LaralCN-UI">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0 1 12 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.02 10.02 0 0 0 22 12.017C22 6.484 17.523 2 12 2Z" />
                            </svg>
                            <span>GitHub</span>
                        </x-ui.sidebar.menu-button>
                    </x-ui.sidebar.menu-item>
                </x-ui.sidebar.menu>
            </x-ui.sidebar.footer>

            <x-ui.sidebar.rail />
        </x-ui.sidebar>

        <x-ui.sidebar.inset>
            {{-- Top bar --}}
            <header
                class="sticky top-0 z-30 flex h-14 shrink-0 items-center gap-2 border-b border-border bg-background/95 px-4 backdrop-blur">
                <x-ui.sidebar.trigger class="-ml-1" />
                <x-ui.separator orientation="vertical" class="mr-2 h-4" />
                <x-ui.breadcrumb>
                    <x-ui.breadcrumb.list>
                        <x-ui.breadcrumb.item class="hidden md:block">
                            <x-ui.breadcrumb.link href="{{ route('home') }}">
                                LaralCN-UI
                            </x-ui.breadcrumb.link>
                        </x-ui.breadcrumb.item>
                        <x-ui.breadcrumb.separator class="hidden md:block" />
                        <x-ui.breadcrumb.item>
                            <x-ui.breadcrumb.page>{{ $title ?? 'Docs' }}</x-ui.breadcrumb.page>
                        </x-ui.breadcrumb.item>
                    </x-ui.breadcrumb.list>
                </x-ui.breadcrumb>

                <div class="ml-auto flex items-center gap-1.5">
                    {{-- Hand this page to an agent: same content, as Markdown. --}}
                    @isset($mdUrl)
                        <button type="button" data-copy-url="{{ $mdUrl }}"
                            class="group inline-flex items-center gap-1.5 rounded-md border border-border px-2 py-1 text-xs text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground">
                            <svg class="size-3.5" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" aria-hidden="true">
                                <rect width="14" height="14" x="8" y="8"
                                    rx="2" ry="2" />
                                <path
                                    d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
                            </svg>
                            <span class="group-data-[copied]:hidden">Copy
                                Page</span>
                            <span
                                class="hidden group-data-[copied]:inline">Copied!</span>
                        </button>
                        <a href="{{ $mdUrl }}" target="_blank"
                            rel="noopener noreferrer" title="View as Markdown"
                            class="rounded-md border border-border px-2 py-1 text-xs text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground">
                            .md
                        </a>
                    @endisset

                    <button type="button" data-theme-toggle
                        class="rounded-md border border-border px-2 py-1 text-xs">
                        <span class="dark:hidden">Dark</span>
                        <span class="hidden dark:inline">Light</span>
                    </button>
                </div>
            </header>

            {{-- Page content --}}
            <div class="mx-auto w-full max-w-5xl flex-1 px-6 py-10">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            <footer class="border-t border-border">
                <div
                    class="mx-auto max-w-5xl px-6 py-8 text-center text-sm text-muted-foreground">
                    Created with love and coffee by
                    <a href="https://abdulkadersafi.com" target="_blank"
                        rel="noopener noreferrer"
                        class="font-medium text-foreground underline underline-offset-4 hover:text-foreground/80">
                        Abdulkader Safi
                    </a>
                    <p class="mt-2 text-xs">
                        Working with an AI agent? Hand it
                        <a href="{{ route('llms') }}"
                            class="underline underline-offset-4 hover:text-foreground">llms.txt</a>
                        or
                        <a href="{{ route('llms.full') }}"
                            class="underline underline-offset-4 hover:text-foreground">llms-full.txt</a>.
                    </p>
                </div>
            </footer>
        </x-ui.sidebar.inset>
    </x-ui.sidebar.provider>
</body>

</html>
