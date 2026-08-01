@php
    $componentDeps = $entry['dependencies']['components'] ?? [];
    $jsDeps = $entry['dependencies']['js'] ?? [];
    $composerDeps = $entry['dependencies']['composer'] ?? [];
    $hasDeps = $componentDeps || $jsDeps || $composerDeps;
@endphp

<x-layouts.app :all="$all" :entry="$entry" :title="$entry['name']">
    {{-- Header --}}
    <div class="mb-8">
        <p class="text-sm text-muted-foreground">{{ $entry['category'] }}</p>
        <h1 class="mt-1 text-3xl font-bold tracking-tight">{{ $entry['name'] }}
        </h1>
        <p class="mt-2 text-muted-foreground">{{ $entry['description'] }}</p>
    </div>

    {{-- Preview / Code --}}
    <section class="mb-10" data-tabs>
        <div class="mb-3 flex items-center gap-1 border-b border-border text-sm">
            <button type="button" data-tab="preview" aria-selected="true"
                class="-mb-px border-b-2 px-3 py-2 font-medium transition-colors border-transparent text-muted-foreground hover:text-foreground aria-selected:border-foreground aria-selected:text-foreground">
                Preview
            </button>
            <button type="button" data-tab="code" aria-selected="false"
                class="-mb-px border-b-2 px-3 py-2 font-medium transition-colors border-transparent text-muted-foreground hover:text-foreground aria-selected:border-foreground aria-selected:text-foreground">
                Code
            </button>
        </div>

        <div data-panel="preview"
            class="flex min-h-[280px] items-center justify-center rounded-lg border border-border bg-card p-10">
            @if ($hasDemo)
                @include($demoView)
            @else
                <span class="text-sm text-muted-foreground">
                    No interactive preview — see the source below.
                </span>
            @endif
        </div>

        <div data-panel="code" class="hidden">
            @if ($demoSource !== null)
                <x-code-block :code="$demoSource" class="min-h-[280px]" />
            @else
                <p class="text-sm text-muted-foreground">
                    No example source available.
                </p>
            @endif
        </div>
    </section>

    {{-- Installation --}}
    <section class="mb-10" data-tabs>
        <h2 class="mb-3 text-xl font-semibold tracking-tight">Installation</h2>

        <div
            class="mb-3 flex items-center gap-1 border-b border-border text-sm">
            <button type="button" data-tab="command" aria-selected="true"
                class="-mb-px border-b-2 px-3 py-2 font-medium transition-colors border-transparent text-muted-foreground hover:text-foreground aria-selected:border-foreground aria-selected:text-foreground">
                Command
            </button>
            <button type="button" data-tab="manual" aria-selected="false"
                class="-mb-px border-b-2 px-3 py-2 font-medium transition-colors border-transparent text-muted-foreground hover:text-foreground aria-selected:border-foreground aria-selected:text-foreground">
                Manual
            </button>
        </div>

        <div data-panel="command">
            <x-code-block :code="$command" language="bash" />
        </div>

        <div data-panel="manual" class="hidden space-y-6">
            <div>
                <p class="mb-2 text-sm font-medium">
                    <span class="text-muted-foreground">1.</span>
                    Install dependencies
                </p>
                @if ($hasDeps)
                    <ul class="space-y-1 text-sm text-muted-foreground">
                        @foreach ($composerDeps as $dep)
                            <li>composer: <code
                                    class="text-foreground">{{ $dep }}</code>
                            </li>
                        @endforeach
                        @foreach ($jsDeps as $dep)
                            <li>npm: <code
                                    class="text-foreground">{{ $dep }}</code>
                            </li>
                        @endforeach
                        @foreach ($componentDeps as $dep)
                            <li>
                                component:
                                <a class="text-foreground underline"
                                    href="{{ route('docs.show', $dep) }}">{{ $dep }}</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-muted-foreground">
                        This component has no dependencies.
                    </p>
                @endif
            </div>

            <div class="space-y-6">
                <p class="text-sm font-medium">
                    <span class="text-muted-foreground">2.</span>
                    Copy {{ count($files) > 1 ? 'each file' : 'the source' }} into
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

    {{-- Usage --}}
    @if ($usageSource !== null)
        <section class="mb-10">
            <h2 class="mb-3 text-xl font-semibold tracking-tight">Usage</h2>
            <x-code-block :code="$usageSource" />
            @if (!empty($entry['tailwind']['notes']))
                <p class="mt-3 text-sm text-muted-foreground">
                    {{ $entry['tailwind']['notes'] }}
                </p>
            @endif
        </section>
    @endif
</x-layouts.app>
