<x-layouts.app :all="$categories" title="Components">
    <section class="mb-12">
        <h1 class="text-4xl font-bold tracking-tight">
            LaralCN-UI
        </h1>
        <p class="mt-3 max-w-2xl text-muted-foreground">
            A shadcn-style, copy-and-own component system for Laravel &amp;
            Blade. Pure Blade + Tailwind v4. {{ $total }} components.
            Install via the CLI or copy the source straight from any page.
        </p>

        <div
            class="mt-6 rounded-lg border border-border bg-card p-4 font-mono text-sm text-card-foreground">
            <div>composer require --dev safi/laralcn-ui</div>
            <div>php artisan ui:init</div>
            <div>php artisan ui:add button</div>
        </div>
    </section>

    @foreach ($categories as $category => $items)
        <section class="mb-10">
            <h2 class="mb-4 text-lg font-semibold">{{ $category }}</h2>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($items as $item)
                    <a href="{{ route('docs.show', $item['name']) }}"
                        class="block rounded-lg border border-border bg-card p-5 text-card-foreground transition-colors hover:border-foreground/30">
                        <span class="font-medium">{{ $item['name'] }}</span>
                        <p class="mt-1 text-sm text-muted-foreground">
                            {{ $item['description'] }}
                        </p>
                    </a>
                @endforeach
            </div>
        </section>
    @endforeach
</x-layouts.app>
