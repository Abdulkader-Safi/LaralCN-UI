# LaralCN-UI

A shadcn/ui-style **copy-and-own** component system for Laravel & Blade.

LaralCN-UI is **not** a component library. You do not depend on a runtime package for the components. You pull individual components into your own project as plain `.blade.php` files that you fully own and can edit.

- **25 components + blocks.** Matched to current shadcn/ui (OKLCH theme, Tailwind v4 sizing/variants), including a full composable `sidebar` and the `sidebar-08` block.
- **Pure Blade + Tailwind v4.** Alpine.js only when interactivity is unavoidable. No React/Vue, no base UI primitive dependency.
- **Two channels.** Install via Artisan CLI, or copy from the website.
- **Yours to edit.** Components live in your source tree. No version coupling.
- **MIT licensed.**

## Channel A: CLI

```bash
composer require --dev safi/laralcn-ui   # once
php artisan ui:init                      # one-time project setup
php artisan ui:add button                # per component
```

```blade
<x-ui.button variant="destructive">Delete</x-ui.button>
```

Commands: `ui:init`, `ui:add`, `ui:list`, `ui:diff`. The CLI is Laravel-only.

## Channel B: copy from the website

Every component has a docs page with a live preview and one-click copyable source. Copy the file into `resources/views/components/ui/`, copy the theme variables once, done. No CLI, no Composer. This is the supported path for plain-Blade and Statamic projects. Multi-file components (e.g. `breadcrumb`, `sidebar`) ship as a Blade namespace — the docs page lists every file with its target path.

## Blocks

Blocks are ready-made, multi-component layouts you copy and own. The site's **Blocks** page (`/blocks`) shows each block with a live preview, the `ui:add` command for the components it composes, and its full source. The first block is **`sidebar-08`** — a collapsible application shell (icon mode, mobile off-canvas, workspace switcher, nav-user) built from `sidebar`, `breadcrumb`, `collapsible`, `dropdown-menu`, `avatar`, `separator`, `button`, and `skeleton`.

```bash
php artisan ui:add sidebar breadcrumb collapsible dropdown-menu avatar separator button skeleton
```

Then paste the block's `<x-ui.sidebar.provider>` composition into your layout. (An installable `ui:add sidebar-08` one-shot is planned — see `component-plan.md`.)

## Requirements

- Laravel app on Tailwind CSS **v4** (the default `laravel new` setup: CSS-first `@import "tailwindcss"`, `@tailwindcss/vite`, no `tailwind.config.js`).
- `gehrisandro/tailwind-merge-laravel` in the consuming project (so `class="px-8"` correctly overrides a component's built-in `px-4`). `ui:init` detects this and prints the install command.
- Alpine.js only for interactive components (Dialog, Dropdown, etc.).

## Repository layout (monorepo)

| Path                | What                                                |
| ------------------- | --------------------------------------------------- |
| `packages/blade-ui` | the `safi/laralcn-ui` installer package + CLI       |
| `registry/`         | single source of truth: component JSON + sources    |
| `website/`          | Laravel docs/showcase app (dogfoods the components) |
| `docs/`             | `DECISIONS.md` (locked calls), `AUTHORING.md`       |

## Contributing

Read `docs/AUTHORING.md` (the component standard) and `docs/DECISIONS.md` (the locked architectural calls) before proposing components.

## License

MIT © 2026 [AbdulKader Safi](https://abdulkadersafi.com)
