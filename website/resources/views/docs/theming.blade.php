<x-layouts.app :all="$all" title="Theming">
    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight">Theming</h1>
        <p class="mt-2 max-w-2xl text-muted-foreground">
            Every component reads its colors, radius, and spacing from CSS
            variables. <code>php artisan ui:init</code> injects this block for
            you. If you copy components by hand (Channel B), paste this once into
            your Tailwind v4 stylesheet and you are done — no component edits.
        </p>
    </div>

    <section x-data="{ copied: false, theme: @js($theme) }">
        <div class="mb-3 flex items-center justify-between">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-muted-foreground">Theme variables</h2>
            <button type="button"
                    class="rounded-md border border-border px-3 py-1 text-xs hover:bg-accent hover:text-accent-foreground"
                    @click="navigator.clipboard.writeText(theme); copied = true; setTimeout(() => copied = false, 1500)">
                <span x-show="!copied">Copy</span>
                <span x-show="copied" x-cloak>Copied!</span>
            </button>
        </div>
        <pre class="overflow-x-auto rounded-lg border border-border text-xs leading-relaxed"><code class="language-css rounded-lg">{{ $theme }}</code></pre>
    </section>
</x-layouts.app>
