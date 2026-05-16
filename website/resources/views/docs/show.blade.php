<x-layouts.app :all="$all" :entry="$entry" :title="$entry['name']">
    <div class="mb-8">
        <p class="text-sm text-muted-foreground">
            {{ $entry['category'] }}
        </p>
        <h1 class="mt-1 text-3xl font-bold tracking-tight">
            {{ $entry['name'] }}
        </h1>
        <p class="mt-2 text-muted-foreground">
            {{ $entry['description'] }}
        </p>
    </div>

    {{-- Live preview: rendered with the real installed component (dogfooding) --}}
    <section class="mb-8">
        <h2
            class="mb-3 text-sm font-semibold uppercase tracking-wide text-muted-foreground">
            Preview
        </h2>
        <div
            class="flex min-h-[160px] items-center justify-center rounded-lg border border-border bg-card p-10">
            @if ($hasPreview)
                @include('previews.' . $entry['name'])
            @else
                <span class="text-sm text-muted-foreground">
                    No interactive preview, see source below.
                </span>
            @endif
        </div>
    </section>

    {{-- Install --}}
    <section class="mb-8 grid gap-4 sm:grid-cols-2">
        <div class="rounded-lg border border-border bg-card p-4">
            <p
                class="mb-2 text-xs font-semibold uppercase tracking-wide text-muted-foreground">
                CLI
            </p>
            <code class="text-sm">{{ $command }}</code>
        </div>
        <div class="rounded-lg border border-border bg-card p-4">
            <p
                class="mb-2 text-xs font-semibold uppercase tracking-wide text-muted-foreground">
                Dependencies
            </p>
            <ul class="space-y-1 text-sm text-muted-foreground">
                @forelse ($entry['dependencies']['components'] ?? [] as $dep)
                    <li>
                        component: <a class="underline"
                            href="{{ route('docs.show', $dep) }}">{{ $dep }}</a>
                    </li>
                @empty
                @endforelse
                @foreach ($entry['dependencies']['js'] ?? [] as $dep)
                    <li>
                        npm: <code>{{ $dep }}</code>
                    </li>
                @endforeach
                @foreach ($entry['dependencies']['composer'] ?? [] as $dep)
                    <li>
                        composer: <code>{{ $dep }}</code>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- Source + copy --}}
    <section class="mb-8" x-data="{ copied: false, source: @js($source) }">
        <div class="mb-3 flex items-center justify-between">
            <h2
                class="text-sm font-semibold uppercase tracking-wide text-muted-foreground">
                Source
            </h2>
            <button type="button"
                class="rounded-md border border-border px-3 py-1 text-xs hover:bg-accent hover:text-accent-foreground"
                @click="navigator.clipboard.writeText(source); copied = true; setTimeout(() => copied = false, 1500)">
                <span x-show="!copied">
                    Copy
                </span>
                <span x-show="copied" x-cloak>
                    Copied!
                </span>
            </button>
        </div>
        <pre
            class="overflow-x-auto rounded-lg border border-border text-xs leading-relaxed"><code class="language-xml rounded-lg">{{ $source }}</code></pre>
        @if (!empty($entry['tailwind']['notes']))
            <p class="mt-3 text-sm text-muted-foreground">
                {{ $entry['tailwind']['notes'] }}
            </p>
        @endif
    </section>
</x-layouts.app>
