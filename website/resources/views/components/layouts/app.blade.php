<!DOCTYPE html>
<html lang="en" x-data="{ dark: false }" :class="{ 'dark': dark }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'LaralCN-UI' }}, LaralCN-UI</title>
    <meta name="description"
        content="A shadcn-style copy-and-own Blade component system for Laravel.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://u.abdulkadersafi.com/script.js"
        data-website-id="759e2030-fd85-4a3c-91c7-59f411fa5698"></script>
    <style>
        [x-cloak] {
            display: none !important
        }
    </style>
</head>

<body class="min-h-screen bg-background text-foreground antialiased">
    <header
        class="sticky top-0 z-40 border-b border-border bg-background/95 backdrop-blur">
        <div class="mx-auto flex h-14 max-w-7xl items-center gap-4 px-6">
            <a href="{{ route('home') }}" class="font-bold tracking-tight">
                LaralCN-UI
            </a>
            <span class="text-xs text-muted-foreground">
                copy-and-own Blade components
            </span>
            <nav class="ml-auto flex items-center gap-4 text-sm">
                <a href="{{ route('docs.index') }}"
                    class="text-muted-foreground hover:text-foreground">
                    Components
                </a>
                <a href="{{ route('blocks.index') }}"
                    class="text-muted-foreground hover:text-foreground">
                    Blocks
                </a>
                <a href="{{ route('docs.theming') }}"
                    class="text-muted-foreground hover:text-foreground">
                    Theming
                </a>
                <a href="{{ route('docs.plain-blade') }}"
                    class="text-muted-foreground hover:text-foreground">
                    Plain Blade
                </a>
                <a href="https://github.com/Abdulkader-Safi/LaralCN-UI"
                    class="text-muted-foreground hover:text-foreground">
                    GitHub
                </a>
                <button type="button" @click="dark = !dark"
                    class="rounded-md border border-border px-2 py-1 text-xs">
                    <span x-show="!dark">
                        Dark
                    </span>
                    <span x-show="dark" x-cloak>
                        Light
                    </span>
                </button>
            </nav>
        </div>
    </header>

    <div class="mx-auto flex max-w-7xl gap-10 px-6 py-10">
        <aside class="hidden w-56 shrink-0 lg:block">
            <nav class="sticky top-20 space-y-6 text-sm">
                <div>
                    <a href="{{ route('docs.getting-started') }}"
                        class="block rounded px-2 py-1 font-semibold hover:bg-accent hover:text-accent-foreground {{ request()->routeIs('docs.getting-started') ? 'bg-accent text-accent-foreground' : 'text-foreground' }}">
                        Getting Started
                    </a>
                </div>
                @foreach ($all ?? collect() as $category => $items)
                    <div>
                        <p class="mb-2 font-semibold text-foreground">
                            {{ $category }}</p>
                        <ul class="space-y-1">
                            @foreach ($items as $item)
                                <li>
                                    <a href="{{ route('docs.show', $item['name']) }}"
                                        class="block rounded px-2 py-1 text-muted-foreground hover:bg-accent hover:text-accent-foreground {{ isset($entry) && $entry['name'] === $item['name'] ? 'bg-accent text-accent-foreground' : '' }}">
                                        {{ $item['name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </nav>
        </aside>

        <main class="min-w-0 flex-1">
            {{ $slot }}
        </main>
    </div>

    <footer class="border-t border-border">
        <div
            class="mx-auto max-w-7xl px-6 py-8 text-center text-sm text-muted-foreground">
            Created with love and coffee by
            <a href="https://abdulkadersafi.com" target="_blank"
                rel="noopener noreferrer"
                class="font-medium text-foreground underline underline-offset-4 hover:text-foreground/80">
                Abdulkader Safi
            </a>
        </div>
    </footer>
</body>

</html>
