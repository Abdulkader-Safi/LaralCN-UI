# Component Docs — shadcn-style Layout

**Date:** 2026-05-16
**Status:** Approved (design phase)

## Goal

Every component documentation page in `website/` should follow the same
structure and visual feel as <https://ui.shadcn.com/docs/components/radix/accordion>:
a Preview/Code toggle, an Installation section with Command/Manual tabs, and a
Usage code block. This applies to all 20 registry components.

## Approach (chosen: A)

All component docs render through a single shared template
(`website/resources/views/docs/show.blade.php`). Restructuring that one file
updates every component at once. Two new per-component example assets are
introduced; the change stays entirely inside the `website/` app and does not
touch the published package, registry schema, `build.php`, or CI.

Fidelity: **structural match** — replicate layout, tab toggles, copy buttons,
and section order using the site's existing theme tokens. Skip shadcn-only
extras (v0 button, in-preview theme/style switcher).

## New per-component assets

Under `website/resources/views/examples/`, two files per component:

- `examples/<name>.blade.php` — the **demo**. Rendered live in the Preview tab
  and its raw file source shown in the Code tab. Seeded by moving the existing
  `resources/views/previews/<name>.blade.php` content as the starting point,
  then curated where a richer demo helps.
- `examples/<name>.usage.blade.php` — the **usage** boilerplate. The minimal
  copy-paste markup for the component. Shown as a code block in the Usage
  section only; never rendered. (`.usage.blade.php` is a plain file read raw;
  it is never resolved as a Blade view.)

The legacy `resources/views/previews/` directory is removed once all demos are
migrated. `landing.blade.php` and `docs/getting-started.blade.php` reference
`previews.button` / `view()->exists('previews.button')` — these are repointed
to the new `examples.*` location as part of the change.

All 20 components (accordion, alert, avatar, badge, button, card, checkbox,
dialog, dropdown-menu, input, label, radio, select, separator, switch, table,
tabs, textarea, toast, tooltip) get both files. Existing preview content is
the seed for every demo, so no demo starts from scratch.

## Controller changes

`DocsController::show` (and the `gettingStarted` / `home` call sites that pass
preview data) change to provide, per component:

- `demoView` — the `examples.<name>` view name to render, plus
  `hasDemo = view()->exists("examples.{$name}")`.
- `demoSource` — raw contents of `examples/<name>.blade.php` (for the Code tab).
- `usageSource` — raw contents of `examples/<name>.usage.blade.php`, or `null`
  when the file is absent (Usage section is then hidden).
- `componentSource` — unchanged: raw component `.blade.php` from the registry
  (used by the Manual install step). Already available as `$source`.
- `command` — unchanged (`php artisan ui:add <name>`).
- `entry` — unchanged registry metadata (dependencies, tailwind notes).

Reading raw example/usage file contents is done with a small helper (local
filesystem read of `resources/views/examples/...`), mirroring how
`Registry::source` reads raw files. Demo and usage files are local app assets,
not registry assets, so they are read directly, not via `Registry`.

## Page structure (`docs/show.blade.php`)

Rendered top to bottom for every component:

1. **Header** — `{{ category }}` eyebrow, `{{ name }}` as H1,
   `{{ description }}` below. (Unchanged from today.)

2. **Preview / Code** — one bordered card. A tab bar with two tabs
   (`Preview`, `Code`) driven by Alpine (`x-data="{ tab: 'preview' }"`).
   - *Preview*: renders `@include(demoView)` centered in a min-height panel
     (fallback text when `!hasDemo`).
   - *Code*: `<pre><code>` of `demoSource` with a Copy button (reuse the
     existing clipboard Alpine pattern from the current Source section).

3. **Installation** — H2 "Installation" with a tab bar
   (`Command`, `Manual`), Alpine-driven.
   - *Command*: the `{{ command }}` string in a code block + Copy button.
   - *Manual*: an ordered list:
     1. Install dependencies — composer deps and js deps from
        `entry.dependencies` rendered as code (only the sub-list(s) that are
        non-empty); component deps from `entry.dependencies.components`
        rendered as links to their docs pages.
     2. Copy the source into
        `resources/views/components/ui/<name>.blade.php` — followed by the
        full `componentSource` in a `<pre><code>` with a Copy button.
   - When a dependency group is empty it is omitted; if there are no
     dependencies at all, step 1 says the component has none.

4. **Usage** — H2 "Usage". Code block of `usageSource` + Copy button. The
   whole section is omitted when `usageSource` is null. Registry
   `tailwind.notes` (currently under Source) moves to render beneath Usage.

Tabs and copy buttons reuse Alpine (already loaded). A small reusable Blade
partial (e.g. `components/code-block.blade.php` in the website app) wraps the
`<pre><code>` + Copy-button pattern so it is not repeated four times; it takes
the code string and an optional language class.

## Out of scope

- No changes to `registry/`, the published `composer.json`, schema, or CI.
- No syntax highlighting engine beyond existing classes/styling.
- No in-preview theme switcher, reset control, or v0 button.
- Sidebar/header layout in `layouts/app.blade.php` is unchanged.

## Testing

- `./vendor/bin/pest --no-coverage` from repo root stays green (these are
  website-view changes; existing suite targets the package/registry).
- Manual verification in the website app: `npm run build && php artisan serve`,
  then visit several component pages (accordion, button, dialog, tooltip,
  badge) and confirm: Preview/Code toggle works, Code shows the demo source,
  Command/Manual tabs work, Manual shows deps + component source, Usage shows
  boilerplate, copy buttons copy the right text, dark mode still works.
- Confirm `landing` and `getting-started` pages still render after the
  preview→examples repoint.

## Migration steps (high level — detailed plan follows)

1. Add `examples/` dir; move each `previews/<name>.blade.php` →
   `examples/<name>.blade.php` (the demo).
2. Author `examples/<name>.usage.blade.php` for all 20 components (minimal
   boilerplate derived from each component's props/API).
3. Add the `code-block` website partial.
4. Update `DocsController` (show/gettingStarted/home) to supply
   demoView/hasDemo/demoSource/usageSource and repoint preview refs.
5. Rewrite `docs/show.blade.php` to the structure above.
6. Repoint `landing.blade.php` and `docs/getting-started.blade.php`.
7. Remove the now-empty `previews/` directory.
8. Verify.
