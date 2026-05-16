# PRD — Blade UI: A shadcn-style component system for Laravel & Blade

**Status:** Draft v1
**Owner:** Abdul Kader Safi
**Last updated:** May 2026

---

## 1. Summary

Blade UI is an open-source, copy-and-own component system for Laravel and plain Blade projects. It is not a component library. Developers do not depend on a runtime package for the components themselves. Instead, they pull individual components into their own project as plain `.blade.php` files that they fully own and can edit.

The model is directly inspired by shadcn/ui, adapted to the Blade and Tailwind ecosystem. Two distribution channels are supported:

- **Channel A — CLI install.** A one-time dev dependency provides an Artisan command that fetches a named component from a remote registry and writes it into the project's components directory.
- **Channel B — Copy from website.** Every component has a documentation page showing a live preview and its full source, which can be copied directly with no tooling.

Components are pure Blade and Tailwind CSS. When interactivity is required, Alpine.js is used. There is no dependency on a base UI primitive library (no Base UI, no Radix equivalent). Every component is self-contained, readable, and editable.

---

## 2. Problem statement

The Laravel ecosystem lacks an equivalent to shadcn/ui. Existing options fall into two camps:

1. **Full component packages** (installed via Composer) where the component markup lives inside the vendor directory. Developers cannot easily edit these without overriding or forking, and upgrades can silently change behavior.
2. **Loose code snippets** scattered across blog posts and gists, with no consistency, no theming system, and no install path.

Developers who want shadcn's model — beautifully designed components that they copy into their own codebase and own outright — have nothing comparable in Blade. Blade UI fills that gap.

### Why "copy and own" matters

- The component is in the project's own source tree, so it is fully editable without fighting a package.
- There is no version coupling. Updating one component never breaks another.
- The code is auditable and visible, which builds trust.
- It works in any Blade context, not only the latest Laravel version.

---

## 3. Goals and non-goals

### Goals

- Provide a registry of high-quality, accessible, pure-Blade components.
- Provide a CLI install path that feels as smooth as `npx shadcn add`.
- Provide a website with live previews and copyable source for every component.
- Keep every component free of any base UI primitive dependency.
- Make components trivially themeable through Tailwind and CSS variables.
- Be fully open source with a permissive license (MIT).

### Non-goals

- Not a runtime component library distributed as a versioned package of views.
- Not a CSS framework. Tailwind is a peer requirement, not bundled.
- Not a design tool or page builder.
- Not tied to Livewire. Components must work in plain Blade; Livewire compatibility is a nice-to-have, not a requirement.
- No React, Vue, or SPA framework involvement anywhere.

---

## 4. Important technical clarification on Channel A

The original concept described an install like:

```
composer require --dev projecturl.com/component-name
```

This is not a valid Composer operation and will not work. Composer resolves packages by `vendor/package` identifiers, and a `require` always installs a complete package, not a single file from a URL. There is no Composer mechanism to "install one component."

The correct and supported design for Channel A is a **two-step model**:

1. **One-time install of the installer package:**

   ```
   composer require --dev safi/blade-ui
   ```

   This package is tiny. It contains only the CLI command logic and configuration. It contains no components and rarely changes.

2. **Per-component install via Artisan:**
   ```
   php artisan ui:add button
   php artisan ui:add dialog
   ```
   Each command fetches the named component from the remote registry and writes the `.blade.php` file (plus any companion files) into the project's configured components directory.

This delivers the exact experience intended — per-component installs into an editable directory — using a mechanism that actually works. The `composer require` happens once; everything after is per-component.

---

## 5. Personas

**The Laravel product developer.** Building an app, wants polished UI fast, does not want a heavy dependency, wants to tweak components to match the product. Primary user of Channel A.

**The freelancer / agency developer.** Spins up many client projects, wants a consistent starting point, values being able to copy a component into a project quickly without committing to tooling. Uses both channels.

**The plain-Blade or Statamic developer.** Not on a full Laravel app, or on an older version. Needs Channel B, or a CLI path that does not assume the latest Laravel.

**The contributor.** Wants to add or improve components. Needs a clear component authoring standard and registry contribution flow.

---

## 6. Product scope

### 6.1 The registry

A machine-readable catalogue of every component, hosted as static JSON.

Each registry entry describes:

- `name` — unique identifier, e.g. `button`.
- `type` — `component`, `block`, or `theme`.
- `description` — short summary.
- `dependencies.components` — other Blade UI components this one requires (e.g. `dialog` requires `button`).
- `dependencies.js` — npm packages required, if any (e.g. `alpinejs`).
- `dependencies.composer` — Composer packages required, if any (expected to be rare or none).
- `files` — array of files to install, each with a target path and either inline content or a fetch URL.
- `tailwind` — any Tailwind theme tokens or CSS variables the component expects.
- `category` — for grouping on the website (Forms, Overlays, Navigation, Feedback, etc.).

The registry is the single source of truth shared by the CLI and the website. The website renders from it; the CLI installs from it.

**Hosting for v1:** static JSON files in the project's GitHub repository, served via raw file URLs or GitHub Pages. No API server. An API can be introduced later if private registries or analytics are needed.

### 6.2 Channel A — the CLI

Delivered as the `safi/blade-ui` dev package. Commands:

- **`ui:init`** — one-time project setup. Verifies Tailwind is present, publishes the config file, creates the components directory if missing, and injects the base CSS variables (theme tokens) into the project's stylesheet. Prompts before overwriting anything.
- **`ui:add <component> [<component>...]`** — resolves the component from the registry, resolves its full dependency tree (components and JS deps), fetches all files, and writes them into the configured directory. Handles existing files by prompting: overwrite, skip, or show diff. Reports any npm packages the user still needs to install.
- **`ui:list`** — lists all available components with descriptions, grouped by category.
- **`ui:diff [<component>]`** — shows the difference between the user's local copy and the current registry version. Important because users own and edit the files; this lets them see upstream changes without blind overwrites.

**Config file** (`config/blade-ui.php`, publishable):

- `components_path` — target directory, default `resources/views/components/ui`.
- `namespace` / `prefix` — component tag prefix, default `ui` (so components render as `<x-ui.button>`).
- `theme` — `css-variables` or `utility-classes`.
- `registry_url` — base URL of the registry, overridable for forks and private registries.
- `js` — `alpine` or `none`, declaring the interactivity strategy.

### 6.3 Channel B — the website

A documentation site that is also a working showcase. For every component it provides:

- A live, interactive preview rendered with the real component.
- The full, copyable source (one click to copy).
- The exact CLI command (`php artisan ui:add <name>`).
- Variants and props documentation.
- Notes on dependencies (e.g. "requires Alpine.js", "requires the `button` component").
- Theming notes.

The site itself is built as a Laravel + Blade application using Blade UI's own components. This is deliberate dogfooding: the docs site is the largest real-world test of the system.

The website must make Channel B fully self-sufficient. A developer who never installs the CLI can still copy every component and use it.

### 6.4 The components

The actual product. Standards every component must meet:

- **Pure Blade.** Authored as anonymous components (`.blade.php` with `@props`), no PHP class required, no base UI primitive dependency.
- **Tailwind for all styling.** No external CSS framework, no component-specific stylesheet beyond Tailwind utilities and theme variables.
- **Alpine.js only when interactivity is unavoidable.** Interactive logic stays inline via `x-data` so the component remains a single self-contained file. Components with no interactivity ship zero JavaScript.
- **Self-contained and readable.** A developer opening the file should understand it immediately. No clever indirection.
- **Accessible.** Correct semantic markup, ARIA attributes, keyboard support, focus management for overlays.
- **Themeable.** Colors, radius, and spacing driven by CSS variables / Tailwind theme tokens, so theming does not require editing component files.
- **Variant-consistent.** A single, consistent pattern for variant logic (size, intent, etc.) applied across every component. Since Blade has no `cva` equivalent, the project defines one small variant helper or a consistent `match`-based convention, decided before the first component ships and never deviated from.

**Initial component set (v1 target):** Button, Input, Label, Textarea, Select, Checkbox, Radio, Switch, Badge, Alert, Card, Avatar, Separator, Dialog/Modal, Dropdown Menu, Tooltip, Tabs, Accordion, Toast, Table. The set is deliberately small at launch; breadth comes after the system is proven.

---

## 7. Key technical challenges

These are known hard problems and must be solved deliberately.

### 7.1 Class merging and Tailwind conflict resolution

shadcn relies on `tailwind-merge` so that a user passing `class="px-8"` correctly overrides a component's built-in `px-4`. Blade's `$attributes->class()` only concatenates classes — it does not resolve Tailwind conflicts, so both `px-4` and `px-8` end up in the markup and the result depends on CSS source order.

**Decision required:** either ship/recommend a small PHP Tailwind-merge equivalent, or clearly document the limitation and the recommended override pattern. This must be settled before the first component ships, because it shapes how every component handles its `class` attribute.

### 7.2 Variant logic

There is no `cva` in Blade. The project must define one consistent variant pattern (a tiny helper or a `match`-based convention) and apply it identically across all components. Inconsistency here makes the library feel amateur.

### 7.3 Dependency resolution in the CLI

`ui:add dialog` must pull in `button` and ensure Alpine.js is accounted for. The resolver must walk the dependency graph, deduplicate, and clearly report JS/npm dependencies the user still needs to install manually.

### 7.4 Theme injection

`ui:init` must inject CSS variables into the user's stylesheet without clobbering existing styles, and must be idempotent (safe to run twice).

### 7.5 Plain-Blade compatibility

The CLI assumes a Laravel app for `php artisan`. Plain-Blade and Statamic users rely on Channel B. The website must therefore be a complete, standalone way to consume every component.

---

## 8. User flows

### Flow A — CLI install

1. Developer runs `composer require --dev safi/blade-ui` once.
2. Runs `php artisan ui:init`; Tailwind is verified, config and theme variables are set up.
3. Runs `php artisan ui:add button`; `button.blade.php` appears in `resources/views/components/ui/`.
4. Uses `<x-ui.button>Save</x-ui.button>` in a view.
5. Edits the file freely; it is their code now.
6. Later runs `ui:add dialog`; the CLI also installs `button` (already present, so skipped or diffed) and reports that Alpine.js is needed.

### Flow B — copy from website

1. Developer visits the Blade UI website.
2. Browses to the Button component page, sees the live preview.
3. Clicks copy, pastes the source into `resources/views/components/ui/button.blade.php`.
4. Copies the theme CSS variables once from the theming page.
5. Uses the component. No CLI, no Composer.

---

## 9. Success metrics

- Time from zero to a rendered component under five minutes via either channel.
- Every component installable via CLI and copyable via website, with parity between the two.
- Component source readable and editable without consulting docs.
- GitHub stars, registry fetch counts, and community-contributed components as adoption signals.
- Issue volume around install friction trending down after launch.

---

## 10. Release plan

### Phase 0 — Foundations

Decide and document the hard calls before writing components: the variant pattern, the class-merge approach, the registry JSON schema, the config file shape, and the component authoring standard.

### Phase 1 — One component, end to end

Build the registry format and the `ui:add` command against exactly one component (Button). Prove the full loop: `composer require` → `ui:init` → `ui:add button` → file written → renders correctly. Do not build many components against an unproven CLI.

### Phase 2 — Dependency resolution

Add `dialog` to force handling of component dependencies (needs Button) and JS dependencies (needs Alpine). Harden the resolver. Add `ui:list`.

### Phase 3 — Component breadth

Build out the v1 component set against the now-proven system. Add `ui:diff`.

### Phase 4 — Website

Build the documentation and showcase site as a Laravel + Blade app consuming Blade UI itself. Ship Channel B fully: live previews, copyable source, theming guide.

### Phase 5 — Public launch

Open source the repository under MIT, publish the installer package, publish the website, document the contribution flow for community components.

---

## 11. Open questions

- Tailwind-merge for PHP: ship one, recommend an existing one, or document the limitation?
- Registry hosting: raw GitHub files for v1 is the plan — confirm before Phase 1.
- Should `ui:init` support a non-Laravel mode, or is Channel B the only supported path for plain Blade and Statamic?
- Alpine.js: bundled guidance in `ui:init`, or left entirely to the user?
- Component versioning: is `ui:diff` against latest sufficient for v1, or is per-component version pinning needed sooner?
- Naming: confirm the package name (`safi/blade-ui`) and the public project name.
