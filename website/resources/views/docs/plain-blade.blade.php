<x-layouts.app :all="$all" title="Plain Blade & Statamic">
    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight">Plain Blade &amp; Statamic
        </h1>
        <p class="mt-2 max-w-2xl text-muted-foreground">
            The <code>ui:*</code> Artisan commands need a Laravel app. If you
            are on plain Blade, Statamic, or an older project, use Channel B —
            this website, instead. It is a fully supported, first-class path.
        </p>
    </div>

    <ol class="max-w-2xl list-decimal space-y-4 pl-5 text-sm leading-relaxed">
        <li>
            Make sure your project uses <strong>Tailwind CSS v4</strong>
            (CSS-first, <code>@import "tailwindcss"</code>).
        </li>
        <li>
            Install the class-merge helper so overrides work:
            <code class="block rounded bg-card p-2">
                composer require gehrisandro/tailwind-merge-laravel
            </code>
        </li>
        <li>
            Copy the theme block once from the
            <a class="underline" href="{{ route('docs.theming') }}">
                Theming page
            </a>
            into your stylesheet. Copy all of it, including the
            <code>@@layer base</code> rule at the bottom — Tailwind v4 defaults
            <code>border-color</code> to <code>currentColor</code>, so without
            it every card and divider draws a black border.
        </li>
        <li>
            Open any component page, click <strong>Copy</strong>, and paste
            the source into <code>
                resources/views/components/ui/&lt;name&gt;.blade.php </code>.
        </li>
        <li>
            Use it: <code>&lt;x-ui.button&gt;Save&lt;/x-ui.button&gt;</code>.
            Interactive components carry their own inline
            <code>&lt;script&gt;</code>, so there is nothing else to load.
        </li>
    </ol>

    <p class="mt-8 text-sm text-muted-foreground">
        The source shown on every page is the exact same file the CLI installs —
        there is no difference between the two channels.
    </p>
</x-layouts.app>
