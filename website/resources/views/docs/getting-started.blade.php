<x-layouts.app :all="$all" title="Getting Started">
    <div class="mb-10">
        <p class="text-sm text-muted-foreground">Guide</p>
        <h1 class="mt-1 text-3xl font-bold tracking-tight">Getting Started</h1>
        <p class="mt-2 max-w-2xl text-muted-foreground">
            LaralCN-UI is copy-and-own: there is no runtime library. You install
            a small dev CLI, then pull plain Blade components into your own
            source tree. Here is the path from zero to your first component.
        </p>
    </div>

    {{-- Step 1 --}}
    <section class="mb-10">
        <h2 class="text-lg font-semibold tracking-tight">
            <span class="text-muted-foreground">1.</span> Install the CLI
        </h2>
        <p class="mt-1 text-sm text-muted-foreground">
            Require the package as a dev dependency. It ships only an Artisan
            CLI, nothing is added to your production runtime.
        </p>
        <div
            class="mt-3 rounded-lg border border-border bg-card p-4 font-mono text-sm text-card-foreground">
            composer require --dev safi/laralcn-ui
        </div>
    </section>

    {{-- Step 2 --}}
    <section class="mb-10">
        <h2 class="text-lg font-semibold tracking-tight">
            <span class="text-muted-foreground">2.</span> Initialise your app
        </h2>
        <p class="mt-1 text-sm text-muted-foreground">
            <code class="rounded bg-muted px-1 py-0.5">ui:init</code> is
            idempotent: it injects the theme tokens into your CSS and creates
            the components directory. Safe to re-run anytime.
        </p>
        <div
            class="mt-3 rounded-lg border border-border bg-card p-4 font-mono text-sm text-card-foreground">
            php artisan ui:init
        </div>
    </section>

    {{-- Step 3 --}}
    <section class="mb-10">
        <h2 class="text-lg font-semibold tracking-tight">
            <span class="text-muted-foreground">3.</span> Add your first
            component: <code class="rounded bg-muted px-1 py-0.5">button</code>
        </h2>
        <p class="mt-1 text-sm text-muted-foreground">
            This copies the Blade file into your app and resolves any
            dependencies (here, the tailwind-merge package).
        </p>
        <div
            class="mt-3 rounded-lg border border-border bg-card p-4 font-mono text-sm text-card-foreground">
            {{ $command }}
        </div>

        @if ($hasDemo)
            <p
                class="mt-6 text-xs font-semibold uppercase tracking-wide text-muted-foreground">
                What you get
            </p>
            <div
                class="mt-2 flex min-h-[140px] items-center justify-center rounded-lg border border-border bg-card p-10">
                @include($demoView)
            </div>
        @endif
    </section>

    {{-- Step 4 --}}
    <section class="mb-10">
        <h2 class="text-lg font-semibold tracking-tight">
            <span class="text-muted-foreground">4.</span> Use it in a view
        </h2>
        <p class="mt-1 text-sm text-muted-foreground">
            The component now lives in your source tree, edit it freely.
        </p>
        <div
            class="mt-3 rounded-lg border border-border bg-card p-4 font-mono text-sm text-card-foreground">
            &lt;x-ui.button&gt;Click me&lt;/x-ui.button&gt;
        </div>

        @if ($source !== '')
            <div class="mt-6">
                <div class="mb-3 flex items-center justify-between">
                    <h3
                        class="text-sm font-semibold uppercase tracking-wide text-muted-foreground">
                        button source
                    </h3>
                </div>
                <x-code-block :code="$source" />
            </div>
        @endif
    </section>

    {{-- Next --}}
    <section class="border-t border-border pt-8">
        <h2 class="text-lg font-semibold tracking-tight">Next steps</h2>
        <div class="mt-4 flex flex-wrap gap-3 text-sm">
            <a href="{{ route('docs.index') }}"
                class="rounded-md border border-border px-4 py-2 hover:bg-accent hover:text-accent-foreground">
                Browse all components
            </a>
            <a href="{{ route('docs.theming') }}"
                class="rounded-md border border-border px-4 py-2 hover:bg-accent hover:text-accent-foreground">
                Theming
            </a>
            <a href="{{ route('docs.plain-blade') }}"
                class="rounded-md border border-border px-4 py-2 hover:bg-accent hover:text-accent-foreground">
                Plain Blade
            </a>
        </div>
    </section>
</x-layouts.app>
