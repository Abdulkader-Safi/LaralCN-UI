<x-layouts.app :all="$all" title="Blocks">
    <section class="mb-10">
        <h1 class="text-4xl font-bold tracking-tight">Blocks</h1>
        <p class="mt-3 max-w-2xl text-muted-foreground">
            Ready-made, multi-component layouts you copy and own. Each block is
            built entirely from LaralCN-UI components — install those with the
            CLI, then paste the block markup into your app.
        </p>
    </section>

    @foreach ($blocks as $block)
        @php
            $command =
                'php artisan ui:add ' . implode(' ', $block['components']);
        @endphp

        <section class="mb-14" x-data="{ tab: 'preview' }">
            <div class="mb-2 flex flex-wrap items-end justify-between gap-3">
                <div>
                    <p class="text-sm text-muted-foreground">
                        {{ $block['category'] }}</p>
                    <h2 class="mt-1 text-2xl font-bold tracking-tight">
                        {{ $block['title'] }}
                    </h2>
                    <p class="mt-1 max-w-2xl text-sm text-muted-foreground">
                        {{ $block['description'] }}
                    </p>
                </div>
                <a href="{{ $block['route'] }}" target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex h-9 shrink-0 items-center rounded-md border border-border px-4 text-sm font-medium hover:bg-accent hover:text-accent-foreground">
                    Open full screen &rarr;
                </a>
            </div>

            {{-- Preview / Code tabs --}}
            <div
                class="mb-3 flex items-center gap-1 border-b border-border text-sm">
                <button type="button" @click="tab = 'preview'"
                    class="-mb-px border-b-2 px-3 py-2 font-medium transition-colors"
                    :class="tab === 'preview' ? 'border-foreground text-foreground' :
                        'border-transparent text-muted-foreground hover:text-foreground'">
                    Preview
                </button>
                <button type="button" @click="tab = 'code'"
                    class="-mb-px border-b-2 px-3 py-2 font-medium transition-colors"
                    :class="tab === 'code' ? 'border-foreground text-foreground' :
                        'border-transparent text-muted-foreground hover:text-foreground'">
                    Code
                </button>
            </div>

            <div x-show="tab === 'preview'"
                class="overflow-hidden rounded-lg border border-border">
                <iframe src="{{ $block['route'] }}" class="h-[600px] w-full"
                    title="{{ $block['title'] }} preview" loading="lazy"></iframe>
            </div>

            <div x-show="tab === 'code'" x-cloak>
                <x-code-block :code="$block['source']" />
            </div>

            {{-- How to use --}}
            <div class="mt-6 grid gap-6 md:grid-cols-2">
                <div>
                    <h3 class="mb-2 text-sm font-semibold">
                        1. Install the components it uses
                    </h3>
                    <x-code-block :code="$command" language="bash" />
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($block['components'] as $component)
                            <a href="{{ route('docs.show', $component) }}"
                                class="rounded-full border border-border px-2.5 py-0.5 text-xs text-muted-foreground hover:text-foreground">
                                {{ $component }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <div>
                    <h3 class="mb-2 text-sm font-semibold">
                        2. Copy the block markup
                    </h3>
                    <p class="text-sm text-muted-foreground">
                        Grab the source from the <strong>Code</strong> tab above
                        (it's the standalone demo page). Drop the
                        <code class="text-foreground">&lt;x-ui.sidebar.provider&gt;</code>
                        composition into your own layout — everything inside is
                        plain Blade you already own.
                    </p>
                </div>
            </div>
        </section>
    @endforeach
</x-layouts.app>
