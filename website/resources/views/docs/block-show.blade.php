@php
    $componentDeps = $entry['dependencies']['components'] ?? [];
    $jsDeps = $entry['dependencies']['js'] ?? [];
    $composerDeps = $entry['dependencies']['composer'] ?? [];
@endphp

<x-layouts.app :all="$all" :entry="$entry" :title="$entry['name']">
    {{-- Header --}}
    <div class="mb-6 flex flex-wrap items-end justify-between gap-3">
        <div>
            <p class="text-sm text-muted-foreground">{{ $entry['category'] }}</p>
            <h1 class="mt-1 text-3xl font-bold tracking-tight">
                {{ $entry['name'] }}
            </h1>
            <p class="mt-2 max-w-2xl text-muted-foreground">
                {{ $entry['description'] }}
            </p>
        </div>
        <a href="{{ $previewUrl }}" target="_blank" rel="noopener noreferrer"
            class="inline-flex h-9 shrink-0 items-center rounded-md border border-border px-4 text-sm font-medium hover:bg-accent hover:text-accent-foreground">
            Open full screen &rarr;
        </a>
    </div>

    {{-- Preview / Code --}}
    <section class="mb-10" x-data="{ tab: 'preview' }">
        <div class="mb-3 flex items-center gap-1 border-b border-border text-sm">
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

        {{-- Preview is rendered at a 1280px desktop viewport and scaled to fit
             the content column, so the block's desktop layout is always shown
             (the column is narrower than the lg breakpoint). --}}
        <div x-show="tab === 'preview'" x-data="{ vw: 1280, h: 720, scale: 1 }"
            x-init="
                const fit = () => { if ($el.clientWidth) scale = Math.min(1, $el.clientWidth / vw); };
                fit();
                new ResizeObserver(fit).observe($el);
            "
            class="overflow-hidden rounded-lg border border-border bg-background">
            <div :style="`height: ${h * scale}px`">
                <iframe src="{{ $previewUrl }}"
                    :style="`width: ${vw}px; height: ${h}px; transform: scale(${scale}); transform-origin: top left`"
                    class="block border-0"
                    title="{{ $entry['name'] }} preview" loading="lazy"></iframe>
            </div>
        </div>

        <div x-show="tab === 'code'" x-cloak>
            <x-code-block :code="$source" />
        </div>
    </section>

    {{-- Installation --}}
    <section class="mb-10" x-data="{ tab: 'command' }">
        <h2 class="mb-3 text-xl font-semibold tracking-tight">Installation</h2>

        <div class="mb-3 flex items-center gap-1 border-b border-border text-sm">
            <button type="button" @click="tab = 'command'"
                class="-mb-px border-b-2 px-3 py-2 font-medium transition-colors"
                :class="tab === 'command' ? 'border-foreground text-foreground' :
                    'border-transparent text-muted-foreground hover:text-foreground'">
                Command
            </button>
            <button type="button" @click="tab = 'manual'"
                class="-mb-px border-b-2 px-3 py-2 font-medium transition-colors"
                :class="tab === 'manual' ? 'border-foreground text-foreground' :
                    'border-transparent text-muted-foreground hover:text-foreground'">
                Manual
            </button>
        </div>

        <div x-show="tab === 'command'">
            <x-code-block :code="$command" language="bash" />
            <p class="mt-3 text-sm text-muted-foreground">
                A single command installs the block's Blade file
                <strong>and every component it depends on</strong>. Render it in your
                own layout as
                <code class="text-foreground">&lt;x-ui.blocks.{{ $entry['name'] }} /&gt;</code>.
            </p>

            @if (!empty($componentDeps))
                <div class="mt-4">
                    <p class="mb-2 text-sm font-medium">Components it includes</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($componentDeps as $dep)
                            <a href="{{ route('docs.show', $dep) }}"
                                class="rounded-full border border-border px-2.5 py-0.5 text-xs text-muted-foreground hover:text-foreground">
                                {{ $dep }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div x-show="tab === 'manual'" x-cloak class="space-y-6">
            <div>
                <p class="mb-2 text-sm font-medium">
                    <span class="text-muted-foreground">1.</span>
                    Install component dependencies
                </p>
                @if (!empty($componentDeps))
                    <x-code-block
                        :code="'php artisan ui:add ' . implode(' ', $componentDeps)"
                        language="bash" />
                @else
                    <p class="text-sm text-muted-foreground">
                        This block has no component dependencies.
                    </p>
                @endif
            </div>

            @if ($composerDeps || $jsDeps)
                <div>
                    <p class="mb-2 text-sm font-medium">
                        <span class="text-muted-foreground">2.</span>
                        External packages
                    </p>
                    <ul class="space-y-1 text-sm text-muted-foreground">
                        @foreach ($composerDeps as $dep)
                            <li>composer:
                                <code class="text-foreground">{{ $dep }}</code>
                            </li>
                        @endforeach
                        @foreach ($jsDeps as $dep)
                            <li>npm:
                                <code class="text-foreground">{{ $dep }}</code>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-6">
                <p class="text-sm font-medium">
                    <span class="text-muted-foreground">{{ $composerDeps || $jsDeps ? '3' : '2' }}.</span>
                    Copy the block source into
                    <code class="text-foreground">resources/views/components/ui/</code>
                </p>
                @foreach ($files as $file)
                    <div>
                        <p class="mb-2 text-xs text-muted-foreground">
                            <code
                                class="text-foreground">resources/views/components/ui/{{ $file['path'] }}</code>
                        </p>
                        <x-code-block :code="$file['code']" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
