# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

LaralCN-UI is a shadcn-style **copy-and-own** Blade component system. There is no runtime component library: the `safi/laralcn-ui` Composer package is only a CLI that fetches plain `.blade.php` files from a registry into the consumer's own source tree. Components are pure Blade + Tailwind v4, Alpine.js only when interactivity is unavoidable.

## Monorepo layout (read this first, it is non-obvious)

- **Root `composer.json` is the published package** (`safi/laralcn-ui`, submitted to Packagist). It autoloads `Safi\LaralcnUi\` from `packages/blade-ui/src/` and registers `LaralcnUiServiceProvider`.
- **`packages/blade-ui/composer.json` is a local-only path-repo shim** with the same package name. It exists _solely_ so the in-repo `website/` can consume the package via a Composer path repository (Composer refuses to install a path package into a directory nested inside that package's own source). Keep its `require` block **and its `version`** in sync with the root `composer.json`.
- **`registry/` is the single source of truth.** One dir per entry, components and blocks alike:
  - `registry/components/<name>/component.json` + `files/*.blade.php`. Single-file components ship `files/<name>.blade.php`; multi-file ones (`sidebar`, `breadcrumb`, `carousel`, …) ship a Blade namespace and install to `components/ui/<name>/`.
  - `registry/blocks/<name>/` has the identical shape. Blocks are ready-made layouts that depend on components; `registry/build.php` reads both directories.
  - `registry/index.json` is **generated, never hand-edit it**.
- **`website/`** is a Laravel 13 docs/showcase app that dogfoods the CLI and reads `registry/` off disk for parity with what `ui:add` installs. It consumes the CLI through the `../packages/blade-ui` path repository declared in `website/composer.json`, so `vendor/safi/laralcn-ui` is a symlink into this repo and always runs the current branch, never a published tag.
- **`docs/DECISIONS.md`** holds locked architectural calls; **`docs/AUTHORING.md`** is the mandatory component standard.
- **`all-components.md`** is a hand-maintained shadcn coverage table. It does not regenerate itself, so update it when adding or removing an entry.

## Commands

Run from the repo root:

```bash
composer install                      # installs deps (vendor/ at root)
./vendor/bin/pest --no-coverage       # full test suite (Pest + Orchestra Testbench)
./vendor/bin/pest --filter=AddCommandTest          # one test file
./vendor/bin/pest --filter='renders the simple'    # one test by name
php registry/build.php                # regenerate registry/index.json after adding/editing any component.json
```

Website (from `website/`):

```bash
composer install && npm install
echo "LARALCN_UI_REGISTRY_URL=$(cd ../registry && pwd)" >> .env   # point CLI/site at the local registry
php artisan ui:init                   # idempotent: injects theme, creates components dir
php artisan ui:add <name>             # dogfood-install a component (resolves deps)
php artisan ui:add-block <name>       # install a block plus every component it composes
php artisan ui:diff                   # PARITY CHECK: how the site's copies differ from registry/
php artisan ui:list                   # every entry, grouped by category
npm run build && php artisan serve
```

After changing CLI source under `packages/blade-ui/src/`, nothing needs reinstalling (the vendor dir is a symlink). After changing the package `version`, run `composer update safi/laralcn-ui` in `website/` to refresh the lock.

## Component authoring (locked rules, see docs/AUTHORING.md)

Every component MUST:

- Be an anonymous Blade component with `@props([...])` defaults.
- Resolve variants with an **inline `match()` block** (no `cva`, no shared helper). Variant/size props are always named `variant` / `size`; every `match` has a `default` arm.
- Funnel base + variant + consumer `class` through `\TailwindMerge\Laravel\Facades\TailwindMerge::merge(...)` (consumer `class` last) and render with `$attributes->except('class')->merge(['class' => $classes])`.
- Be 100% self-contained: the **only** external symbol allowed is `TailwindMerge`. No project helper, trait, or base component, a file copied from the website must work standalone.
- Use theme tokens only (`bg-primary`, `text-muted-foreground`, `rounded-md`, `--radius`, …), never hardcoded colors. Tailwind **v4 only** (CSS-first `@theme`, no `tailwind.config.js`).
- **Write every Tailwind class out in full, in the source text.** Tailwind scans files as plain text and has no idea what PHP evaluates to, so a class assembled by interpolation or concatenation is silently never compiled: `"group-data-[state=collapsed]:{$offscreen}"` produced no CSS at all and shipped a sidebar that would not collapse. Branch with `match(true)` over whole literal class strings instead. Nothing in the test suite catches this; the only proof is `grep` in `website/public/build/assets/*.css` after `npm run build`.
- Declare `gehrisandro/tailwind-merge-laravel` in `dependencies.composer`, and any Alpine plugin in `dependencies.js`.

After changing any `component.json`, run `php registry/build.php` or the registry-integrity CI job fails.

## Architecture notes

- **CLI flow:** `RegistryClient` (reads index/component/file from a remote raw URL _or_ a local path) → `DependencyResolver` (recursive, deduped, topological; aggregates js/composer deps) → `FileInstaller` (writes files; conflict resolution is delegated to a caller closure so the command owns the interactive UX). `ThemeInjector` writes the theme block between sentinel markers and is idempotent.
- **`registry_url`** (config `laralcn-ui.registry_url`, env `LARALCN_UI_REGISTRY_URL`) accepts an `http(s)` base (raw GitHub, the published default) or an absolute filesystem path (monorepo dev). Tests and the website use the local-path mode.
- **Tests** live in `/tests`, run from the repo root against the real `registry/` directory. `SmokeRenderTest` copies registry components into a Testbench app's `resources/views/components/ui` and renders them to prove the tailwind-merge override actually works; `SchemaValidationTest` validates every `component.json` and that `index.json` is in sync.
- **Channel parity:** the website never reimplements components, it renders the real registry files and shows their exact source, so CLI install and copy-from-site are guaranteed identical. This only holds while `website/resources/views/components/ui/` is byte-identical to `registry/`; after editing a registry file, re-run `ui:add` (or copy the file across) and confirm with `php artisan ui:diff`.

## Shipping

- **Built assets are committed.** `website/public/build/` is deliberately not gitignored: the VPS Node is too old for Vite and `deploy.sh` never builds. After touching any website view, CSS, or JS, run `npm run build` and commit the output, or production silently keeps serving the old bundle. See `DEPLOYMENT.md`.
- **A release bumps `version` in two files:** root `composer.json` and `packages/blade-ui/composer.json`. Then refresh `website/composer.lock`, tag `vX.Y.Z`, and publish with `gh release create`. Packagist tracks the root manifest.
