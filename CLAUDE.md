# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

LaralCN-UI is a shadcn-style **copy-and-own** Blade component system. There is no runtime component library: the `safi/laralcn-ui` Composer package is only a CLI that fetches plain `.blade.php` files from a registry into the consumer's own source tree. Components are pure Blade + Tailwind v4, Alpine.js only when interactivity is unavoidable.

## Monorepo layout (read this first, it is non-obvious)

- **Root `composer.json` is the published package** (`safi/laralcn-ui`, submitted to Packagist). It autoloads `Safi\LaralcnUi\` from `packages/blade-ui/src/` and registers `LaralcnUiServiceProvider`.
- **`packages/blade-ui/composer.json` is a local-only path-repo shim** with the same package name. It exists _solely_ so the in-repo `website/` can consume the package via a Composer path repository (Composer refuses to install a path package into a directory nested inside that package's own source). Keep its `require` block in sync with the root `composer.json`.
- **`registry/` is the single source of truth.** One dir per component:
  - `registry/components/<name>/component.json` + `files/<name>.blade.php`.
  - `registry/index.json` is **generated, never hand-edit it**.
- **`website/`** is a Laravel 13 docs/showcase app that dogfoods the CLI and reads `registry/` off disk for parity with what `ui:add` installs.
- **`docs/DECISIONS.md`** holds locked architectural calls; **`docs/AUTHORING.md`** is the mandatory component standard.

## Commands

Run from the repo root:

```bash
composer install                      # installs deps (vendor/ at root)
./vendor/bin/pest --no-coverage       # full test suite (Pest + Orchestra Testbench)
./vendor/bin/pest --filter=AddCommandTest          # one test file
./vendor/bin/pest --filter='renders the simple'    # one test by name
php registry/build.php                # regenerate registry/index.json after adding/editing a component
```

Website (from `website/`):

```bash
composer install && npm install
echo "LARALCN_UI_REGISTRY_URL=$(cd ../registry && pwd)" >> .env   # point CLI/site at the local registry
php artisan ui:init                   # idempotent: injects theme, creates components dir
php artisan ui:add <name>             # dogfood-install a component (resolves deps)
npm run build && php artisan serve
```

## Component authoring (locked rules, see docs/AUTHORING.md)

Every component MUST:

- Be an anonymous Blade component with `@props([...])` defaults.
- Resolve variants with an **inline `match()` block** (no `cva`, no shared helper). Variant/size props are always named `variant` / `size`; every `match` has a `default` arm.
- Funnel base + variant + consumer `class` through `\TailwindMerge\Laravel\Facades\TailwindMerge::merge(...)` (consumer `class` last) and render with `$attributes->except('class')->merge(['class' => $classes])`.
- Be 100% self-contained: the **only** external symbol allowed is `TailwindMerge`. No project helper, trait, or base component, a file copied from the website must work standalone.
- Use theme tokens only (`bg-primary`, `text-muted-foreground`, `rounded-md`, `--radius`, …), never hardcoded colors. Tailwind **v4 only** (CSS-first `@theme`, no `tailwind.config.js`).
- Declare `gehrisandro/tailwind-merge-laravel` in `dependencies.composer`, and any Alpine plugin in `dependencies.js`.

After changing any `component.json`, run `php registry/build.php` or the registry-integrity CI job fails.

## Architecture notes

- **CLI flow:** `RegistryClient` (reads index/component/file from a remote raw URL _or_ a local path) → `DependencyResolver` (recursive, deduped, topological; aggregates js/composer deps) → `FileInstaller` (writes files; conflict resolution is delegated to a caller closure so the command owns the interactive UX). `ThemeInjector` writes the theme block between sentinel markers and is idempotent.
- **`registry_url`** (config `laralcn-ui.registry_url`, env `LARALCN_UI_REGISTRY_URL`) accepts an `http(s)` base (raw GitHub, the published default) or an absolute filesystem path (monorepo dev). Tests and the website use the local-path mode.
- **Tests** live in `/tests`, run from the repo root against the real `registry/` directory. `SmokeRenderTest` copies registry components into a Testbench app's `resources/views/components/ui` and renders them to prove the tailwind-merge override actually works; `SchemaValidationTest` validates every `component.json` and that `index.json` is in sync.
- **Channel parity:** the website never reimplements components, it renders the real registry files and shows their exact source, so CLI install and copy-from-site are guaranteed identical.
