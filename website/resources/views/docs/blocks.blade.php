<x-layouts.app :all="$all" :blocks="$blocks" title="Blocks">
    <section class="mb-12">
        <h1 class="text-4xl font-bold tracking-tight">Blocks</h1>
        <p class="mt-3 max-w-2xl text-muted-foreground">
            Ready-made, multi-component layouts you copy and own. Each block is
            built entirely from LaralCN-UI components. Install a block and every
            component it depends on with a single command:
        </p>

        <div
            class="mt-6 rounded-lg border border-border bg-card p-4 font-mono text-sm text-card-foreground">
            <div>php artisan ui:add-block sidebar-08</div>
        </div>

        <p class="mt-3 text-sm text-muted-foreground">
            {{ $total }} {{ Str::plural('block', $total) }} available.
        </p>
    </section>

    @foreach ($blocks as $category => $items)
        <section class="mb-10">
            <h2 class="mb-4 text-lg font-semibold">{{ $category }}</h2>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($items as $item)
                    <a href="{{ route('blocks.show', $item['name']) }}"
                        class="group block overflow-hidden rounded-lg border border-border bg-card text-card-foreground transition-colors hover:border-foreground/30">
                        <div
                            class="relative aspect-video overflow-hidden border-b border-border bg-muted/30">
                            <iframe
                                src="{{ route('blocks.preview', $item['name']) }}"
                                class="pointer-events-none absolute left-0 top-0 h-[800px] w-[1280px] origin-top-left scale-[0.25]"
                                title="{{ $item['name'] }} thumbnail"
                                loading="lazy" aria-hidden="true"></iframe>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <span
                                    class="font-medium">{{ $item['name'] }}</span>
                                @if (in_array('alpinejs', $item['dependencies']['js'] ?? []))
                                    <span
                                        class="rounded-full bg-muted px-2 py-0.5 text-[10px] text-muted-foreground">Alpine</span>
                                @endif
                            </div>
                            <p
                                class="mt-1 line-clamp-2 text-sm text-muted-foreground">
                                {{ $item['description'] }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endforeach

    @if ($total === 0)
        <p class="text-sm text-muted-foreground">
            No blocks yet — run <code class="text-foreground">php
                registry/build.php</code>
            after dropping a directory into <code
                class="text-foreground">registry/blocks/</code>.
        </p>
    @endif
</x-layouts.app>
