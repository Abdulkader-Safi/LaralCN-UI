<x-layouts.app :all="$all" title="Theming" :md-url="route('docs.theming.md')">
    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight">Theming</h1>
        <p class="mt-2 max-w-2xl text-muted-foreground">
            Every component reads its colors, radius, and spacing from CSS
            variables. <code>php artisan ui:init</code> injects this block for
            you. If you copy components by hand (Channel B), paste this once
            into
            your Tailwind v4 stylesheet and you are done, no component edits.
        </p>
        <p class="mt-2 max-w-2xl text-muted-foreground">
            Paste the whole block, the <code>@@layer base</code> rule at the
            bottom included. Tailwind v4 defaults <code>border-color</code> to
            <code>currentColor</code>, so a card or an accordion divider draws a
            black border until that rule points it at <code>--border</code>.
        </p>
    </div>

    <section>
        <div class="mb-3 flex items-center justify-between">
            <h2
                class="text-sm font-semibold uppercase tracking-wide text-muted-foreground">
                Theme variables</h2>
        </div>
        <x-code-block :code="$theme" language="css" />
    </section>
</x-layouts.app>
