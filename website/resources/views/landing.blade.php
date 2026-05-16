<x-layouts.app :all="$categories" title="Laravel + Blade components you own">
    {{-- Hero --}}
    <section class="border-b border-border pb-12">
        <span
            class="inline-block rounded-full border border-border px-3 py-1 text-xs text-muted-foreground">
            copy-and-own · no runtime library
        </span>
        <h1 class="mt-5 text-5xl font-bold tracking-tight">
            Blade components you actually own.
        </h1>
        <p class="mt-4 max-w-2xl text-lg text-muted-foreground">
            LaralCN-UI is a shadcn-style component system for Laravel &amp;
            Blade. The CLI copies plain <code
                class="rounded bg-muted px-1 py-0.5 text-sm">.blade.php</code>
            files straight into your source tree, pure Blade + Tailwind v4,
            Alpine.js only when interactivity is unavoidable.
            <strong class="text-foreground">{{ $total }}</strong>
            components,
            zero lock-in.
        </p>

        <div
            class="mt-6 rounded-lg border border-border bg-card p-4 font-mono text-sm text-card-foreground">
            <div>composer require --dev safi/laralcn-ui</div>
            <div>php artisan ui:init</div>
            <div>php artisan ui:add button</div>
        </div>

        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('docs.index') }}"
                class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90">
                Browse {{ $total }} components
            </a>
            <a href="https://github.com/Abdulkader-Safi/LaralCN-UI"
                class="rounded-md border border-border px-4 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground">
                View on GitHub
            </a>
        </div>
    </section>

    {{-- Why --}}
    <section class="border-b border-border py-12">
        <h2 class="text-2xl font-semibold tracking-tight">Why LaralCN-UI</h2>
        <div class="mt-6 grid gap-4 sm:grid-cols-2">
            @php
                $features = [
                    [
                        'Copy-and-own',
                        'No package in your runtime. The CLI fetches the source into your app, edit it, ship it, it is yours.',
                    ],
                    [
                        'Pure Blade + Tailwind v4',
                        'CSS-first @theme tokens, no tailwind.config.js. Every component reads theme tokens, never hardcoded colors.',
                    ],
                    [
                        'Alpine only when needed',
                        'Static components stay static. Interactivity is opt-in and declared per component.',
                    ],
                    [
                        'Dependency resolver',
                        'ui:add walks the dependency graph, components, JS, and Composer deps are resolved and installed for you.',
                    ],
                ];
            @endphp
            @foreach ($features as [$title, $body])
                <div
                    class="rounded-lg border border-border bg-card p-5 text-card-foreground">
                    <h3 class="font-medium">{{ $title }}</h3>
                    <p class="mt-1 text-sm text-muted-foreground">
                        {{ $body }}
                    </p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Showcase --}}
    <section class="border-b border-border py-12">
        <div class="flex items-end justify-between">
            <h2 class="text-2xl font-semibold tracking-tight">
                Real components, rendered live
            </h2>
            <a href="{{ route('docs.index') }}"
                class="text-sm text-muted-foreground hover:text-foreground">
                See all →
            </a>
        </div>
        <p class="mt-2 max-w-2xl text-sm text-muted-foreground">
            These previews render the exact registry files
            <code class="rounded bg-muted px-1 py-0.5">ui:add</code> installs —
            the site dogfoods the CLI.
        </p>

        <div class="mt-6 space-y-4">
            @foreach ($showcase as $item)
                <a href="{{ route('docs.show', $item['name']) }}"
                    class="block rounded-lg border border-border bg-card p-6 text-card-foreground transition-colors hover:border-foreground/30">
                    <div class="mb-4 flex items-center justify-between text-sm">
                        <span class="font-medium">{{ $item['name'] }}</span>
                        <span class="text-muted-foreground">
                            {{ $item['description'] }}
                        </span>
                    </div>
                    @include('previews.' . $item['name'])
                </a>
            @endforeach
        </div>
    </section>

    {{-- Footer --}}
    <footer class="py-10 text-sm text-muted-foreground">
        <div class="flex flex-wrap gap-x-6 gap-y-2">
            <a href="{{ route('docs.index') }}"
                class="hover:text-foreground">Components</a>
            <a href="{{ route('docs.theming') }}"
                class="hover:text-foreground">Theming</a>
            <a href="{{ route('docs.plain-blade') }}"
                class="hover:text-foreground">Plain Blade</a>
            <a href="https://github.com/Abdulkader-Safi/LaralCN-UI"
                class="hover:text-foreground">GitHub</a>
            <a href="https://packagist.org/packages/safi/laralcn-ui"
                class="hover:text-foreground">Packagist</a>
        </div>
        <p class="mt-4">
            LaralCN-UI, copy-and-own Blade components for Laravel.
        </p>
    </footer>
</x-layouts.app>
