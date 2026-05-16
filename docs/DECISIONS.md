# LaralCN-UI — Locked Decisions

These are the hard calls the PRD (§7, §11) requires settling before any component ships. They are **locked**. Changing one means changing every component, so they do not change without a deliberate, project-wide migration.

## D1. Distribution model

Copy-and-own. Components are plain `.blade.php` files written into the consumer's own source tree. There is **no runtime component package**. The `safi/laralcn-ui` Composer package (public project name: **LaralCN-UI**, PHP namespace `Safi\LaralcnUi`) contains only CLI/installer logic and config — never components.

## D2. Class-conflict resolution (PRD §7.1)

We depend on the maintained PHP port **`gehrisandro/tailwind-merge-laravel`**.

Every component funnels its base classes, variant classes, and the user-supplied `class` attribute through `TailwindMerge::merge(...)` so that a consumer passing `class="px-8"` correctly overrides a built-in `px-4` (last-wins, Tailwind-aware).

This is a **target-project dependency**, not a dependency of the installer package. It is surfaced three ways so Channel B (copy-from-website) users are not surprised:

- `dependencies.composer` in every component's registry entry.
- Per-component documentation ("requires `gehrisandro/tailwind-merge-laravel`").
- `ui:init` detects it and prints the exact `composer require` line.

Rationale: shipping our own merger is perpetual maintenance against Tailwind's evolving utility space; documenting the limitation reproduces the single biggest papercut of copying shadcn components into Blade. An existing, maintained port gives shadcn-equivalent behavior with zero maintenance burden for us.

## D3. Variant logic (PRD §7.2)

There is no `cva` in Blade. The project-wide convention is an **inline `match()`-based `@php` block** inside each anonymous component. It is **not** a shared helper.

Reason: a component copied from the website must be 100% self-contained. The only external symbol a component may reference is `TailwindMerge` (D2). A variant helper that lived in the installer package would break every copy-paste user.

The fixed structure (see `AUTHORING.md` for the full rule) is:

```blade
@props(['variant' => 'default', 'size' => 'md'])
@php
    $base = '...';
    $variants = match ($variant) {
        'destructive' => '...',
        default => '...',
    };
    $sizes = match ($size) {
        'sm' => '...',
        default => '...',
    };
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        $base, $variants, $sizes, $attributes->get('class')
    );
@endphp
<button {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
```

`default` is always the fallback arm of every `match`. Variant prop names are `variant` and `size` across all components — never `type`, `intent`, `color`.

## D4. Tailwind target

**Tailwind CSS v4 only** — exactly what `laravel new` ships today: CSS-first (`@import "tailwindcss";` + `@theme`), the `@tailwindcss/vite` plugin, and **no `tailwind.config.js`**. Components use v4 utility names. `ui:init` injects theme tokens as CSS variables into the app's main CSS file, not a JS config.

We do not support Tailwind v3. Plain-Blade/Statamic users on older setups are served by Channel B (manual copy) with documented theme variables.

## D5. Registry

- Single source of truth: `/registry` in this monorepo.
- One directory per component: `registry/components/<name>/component.json` plus `files/`.
- `registry/index.json` is the assembled catalogue (generated from the per-component entries; never hand-edited once the build script exists in Phase 3).
- Schema: `registry/schema.json` (JSON Schema). Every entry must validate.
- Hosting for v1: raw GitHub file URLs. No API server. The CLI may also point `registry_url` at a local path for monorepo development.

## D6. Config shape

`config/laralcn-ui.php` keys (locked):

| key               | default                         | meaning                                  |
| ----------------- | ------------------------------- | ---------------------------------------- |
| `components_path` | `resources/views/components/ui` | where components are written             |
| `prefix`          | `ui`                            | tag prefix → `<x-ui.button>`             |
| `theme`           | `css-variables`                 | theming strategy                         |
| `registry_url`    | public raw GitHub base          | registry root; overridable for forks     |
| `js`              | `alpine`                        | interactivity strategy (`alpine`/`none`) |
| `css_path`        | `resources/css/app.css`         | file `ui:init` injects theme vars into   |

## D7. CLI scope

- `ui:init`, `ui:add`, `ui:list`, `ui:diff`.
- Laravel-only (requires `php artisan`). No non-Laravel CLI mode in v1.
- `ui:init` must be idempotent (safe to run repeatedly).
- `ui:diff` compares against registry **latest**. No per-component version pinning in v1.
- Alpine.js is **not** bundled. `ui:init` detects it and prints guidance only.
