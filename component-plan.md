# LaralCN-UI — Component & Blocks Build Plan

Roadmap for the missing components in [`all-components.md`](./all-components.md),
sequenced so we can ship a real shadcn-style **block** (`sidebar-08`) as the first
milestone.

## Status — ✅ Track A shipped (Phases 0–4)

`skeleton`, `collapsible`, `breadcrumb`, `sheet`, and the `sidebar` compound are
built, tested (68 passing), and live on the site; `sidebar-08` ships as a
full-screen demo at `/blocks/sidebar-08` and in the `/blocks` gallery. Registry is
at **25 components**. What actually shipped vs. the plan below:

- **`collapsible`** shipped as **3 namespaced files** (`index`/`trigger`/`content`,
  used as `<x-ui.collapsible.*>`), not the named-slot variant the draft suggested —
  consistent with breadcrumb/sidebar namespacing.
- **`sidebar`** is **self-contained**: tooltip, separator and skeleton behaviour are
  inlined into its parts, so its `dependencies.components` is empty (the *block*
  composes button/breadcrumb/dropdown-menu/avatar/etc., not the primitive).
- **Mobile off-canvas** is inlined in `sidebar/index.blade.php` (overlay + slide +
  `x-trap`) rather than composing `<x-ui.sheet>`, because the sheet's trigger-slot
  model doesn't fit the provider's `openMobile` state.
- **Foundational:** `SmokeRenderTest` now installs by each `component.json`
  `files[].path` (faithful to `FileInstaller`), which is what makes namespaced
  multi-file components resolve. The docs "Manual" tab renders every file.

**Phase 5** (installable `blocks/` registry type + `ui:add sidebar-08`) and
Tracks B/C remain future work.

## Decisions driving this plan

1. **Priority = the Sidebar.** We build only the components needed to assemble the
   shadcn **sidebar blocks** (sidebar-01 … sidebar-16, target `sidebar-08`).
   **Out of scope** (not wanted right now, need real JS libraries): Calendar, Chart,
   Data Table, Date Picker, Carousel, Combobox, Command.
2. **Blocks are phased.** Components first → demo the block as a `website/` showcase
   page now → add an installable `blocks/` registry type to the CLI later.
3. **Every component obeys [`docs/AUTHORING.md`](./docs/AUTHORING.md):** anonymous
   Blade, `@props` defaults, inline `match()` with a `default` arm, classes through
   `TailwindMerge::merge(...)` (consumer `class` last), `$attributes->except('class')->merge(...)`,
   theme tokens only, Alpine **inline `x-data`** only when interactivity is
   unavoidable, a validating `component.json`, and `php registry/build.php` after.
4. **Prerequisite already done.** The OKLCH theme migration shipped the
   `--sidebar`, `--sidebar-foreground`, `--sidebar-primary`, `--sidebar-accent`,
   `--sidebar-border`, `--sidebar-ring` tokens (and `--color-sidebar-*` mappings).
   No theme work is required to start.

## The key insight

The sidebar primitive is built **once**. Every sidebar block (01–16) is just an
_assembly_ of that primitive plus already-shipped components. So this plan delivers
one hard compound component (`sidebar`) and four small ones; after that, `sidebar-08`
— and every other sidebar block — is composition, not new primitives.

---

## Track A — Sidebar track (the priority)

### Dependency graph for `sidebar-08`

```
sidebar-08 (block)
├── sidebar ........... BUILD (compound, Alpine + CSS vars + cookie)
│   ├── sheet ......... BUILD (off-canvas overlay, powers mobile sidebar)
│   ├── skeleton ...... BUILD (menu loading placeholder)
│   ├── tooltip ....... ✅ have (icon-mode labels)
│   ├── button ........ ✅ have
│   ├── separator ..... ✅ have
│   └── input ......... ✅ have (sidebar search form)
├── breadcrumb ........ BUILD (header trail)
├── collapsible ....... BUILD (nav groups / submenus)
├── dropdown-menu ..... ✅ have (workspace switcher, nav-user)
├── avatar ............ ✅ have (nav-user)
└── label ............. ✅ have
```

**Five components to build:** `skeleton`, `collapsible`, `breadcrumb`, `sheet`,
`sidebar` — in that order (cheap → hard, each unblocking the next).

### A1. `skeleton` — no JS

- One element: `<div class="bg-accent animate-pulse rounded-md">`.
- `@props([])`; pass-through `class`. Used by `SidebarMenuSkeleton`.
- Registry deps: `gehrisandro/tailwind-merge-laravel` only.
- **Done when:** renders, consumer `class` overrides size, in `SmokeRenderTest`.

### A2. `collapsible` — Alpine (trivial)

- Anatomy: root (`x-data="{ open }"`), trigger (`@click="open=!open"`,
  `aria-expanded`), content (`x-show` + `x-collapse`, `x-cloak`).
- `@props(['open' => false])`. Use `@alpinejs/collapse` (already a registry-known
  JS dep via accordion) — declare `alpinejs` + `@alpinejs/collapse` in
  `dependencies.js`.
- Ships as 3 files (`collapsible.blade.php`, `collapsible-trigger.blade.php`,
  `collapsible-content.blade.php`) or one file with named slots — pick slots to stay
  single-file per current convention. **Recommend named slots.**
- **Done when:** toggles, keyboard-operable, declared Alpine dep, smoke test.

### A3. `breadcrumb` — no JS

- Anatomy: `breadcrumb` (`<nav aria-label="breadcrumb">`), `list` (`<ol>`),
  `item` (`<li>`), `link` (`<a>`), `page` (`<span aria-current="page">`),
  `separator` (chevron svg, `aria-hidden`), `ellipsis`.
- Multi-file component (registry `files[]` supports this) under
  `registry/components/breadcrumb/files/`, used as `<x-ui.breadcrumb>`,
  `<x-ui.breadcrumb.item>`, etc.
- Theme tokens: `text-muted-foreground`, `text-foreground` on the current page.
- **Done when:** semantic markup + ARIA correct, renders in website, smoke test.

### A4. `sheet` — Alpine (off-canvas)

- The mobile sidebar IS a sheet, so this is a hard dependency.
- Reuse the existing `dialog` Alpine pattern (`x-data="{ open }"`,
  `x-teleport="body"`, `x-trap.noscroll.inert`, `@keydown.escape.window`,
  overlay `bg-black/50`, focus restore).
- Add a `side` prop → `match()` for `top|right|bottom|left` positioning + slide
  transitions. `@props(['side' => 'right'])`.
- Anatomy: trigger slot, content (`role="dialog" aria-modal="true"`), header, title,
  description, footer, close button (matches updated dialog close button).
- Registry deps: `alpinejs`, `gehrisandro/tailwind-merge-laravel`.
- **Done when:** opens/closes from each side, focus trapped + restored, Esc closes,
  scroll locked, smoke + render test.

### A5. `sidebar` — Alpine compound (the hard one)

- **Ships as a multi-file component** (one registry entry, many `files[]`), exposed
  as a Blade namespace: `<x-ui.sidebar.provider>`, `<x-ui.sidebar>`,
  `<x-ui.sidebar.header>`, `.content`, `.group`, `.group-label`, `.group-content`,
  `.menu`, `.menu-item`, `.menu-button`, `.menu-action`, `.menu-badge`,
  `.menu-sub`, `.menu-sub-item`, `.menu-sub-button`, `.menu-skeleton`, `.footer`,
  `.rail`, `.inset`, `.trigger`, `.separator`.
- **State (replaces React context + cookie):**
  - `provider` owns `x-data` with `open`, `openMobile`, `isMobile`, `state`
    (`expanded`/`collapsed`), `toggleSidebar()`.
  - Persist `open` to a cookie (`sidebar_state`) so SSR + reloads keep the choice —
    write via Alpine `$watch` + `document.cookie`.
  - Keyboard shortcut **⌘/Ctrl-B** toggles (window keydown listener in `x-data`).
  - Width via CSS vars `--sidebar-width: 16rem`, `--sidebar-width-icon: 3rem`
    set on the provider; `collapsible="icon"` mode collapses to the icon width.
  - Desktop = inline collapsible panel; **mobile (`isMobile`) renders the panel
    inside `sheet`** (off-canvas). `isMobile` from a `matchMedia('(max-width:
768px)')` listener.
- Colors: `bg-sidebar text-sidebar-foreground`, borders `border-sidebar-border`,
  active item `bg-sidebar-accent text-sidebar-accent-foreground`, focus
  `ring-sidebar-ring` — all tokens already in the theme.
- `menu-button` supports `size` (`default|sm|lg`) and `isActive` via inline
  `match()`; in `collapsible="icon"` mode it shows a `tooltip` with the label.
- Registry deps: components `sheet`, `skeleton`, `tooltip`, `button`, `separator`,
  `input`; js `alpinejs`; composer `gehrisandro/tailwind-merge-laravel`. The
  recursive `DependencyResolver` already aggregates these — no resolver change.
- **Done when:** expand/collapse persists across reload, ⌘B works, icon mode shows
  tooltips, mobile opens as a sheet, focus management correct, renders in website,
  smoke test covers the primary parts.

### A6. `sidebar-08` block (Phase B-now: website demo)

- Build `website/resources/views/blocks/sidebar-08.blade.php` composing the
  primitive: `provider` → inset layout, header with `sidebar.trigger` +
  `separator` + `breadcrumb`, sidebar with workspace `dropdown-menu`, `collapsible`
  nav groups, `menu` items, footer `nav-user` (`avatar` + `dropdown-menu`).
- Add a route + nav entry so it's viewable and pushable online.
- Verify the exact anatomy against the live `sidebar-08` preview before finalizing
  (block numbering/contents can shift upstream).

---

## Track B — other Blade/Alpine-feasible components (later, not required for sidebar)

Available to build with the same authoring rules **if/when wanted**. None block the
sidebar; listed for completeness of "all missing components."

| Group      | Components                                                                | JS?             |
| ---------- | ------------------------------------------------------------------------- | --------------- |
| Overlays   | Alert Dialog, Drawer, Popover, Hover Card, Context Menu                   | Alpine (inline) |
| Navigation | Pagination, Navigation Menu, Menubar                                      | none / Alpine   |
| Form       | Slider, Toggle, Toggle Group, Input Group, Input OTP, Field               | none / Alpine   |
| Display    | Progress, Spinner, Empty, Aspect Ratio, Kbd, Scroll Area, Resizable, Item | none / Alpine   |

> `Native Select` parity already met by our `select`. `Sonner`/`Toast` covered by
> our `toast`. `Direction` and `Typography` are upstream guides, not components.

## Track C — out of scope (your direction: "only the sidebar, not charts or anything else")

`Calendar`, `Chart`, `Data Table`, `Date Picker`, `Carousel`, `Combobox`, `Command`
— excluded. Each needs a real JS library (date engine, charting, TanStack Table,
Embla), which conflicts with the "Blade + Tailwind, Alpine only when unavoidable, no
runtime library" rule. Revisit only if the policy changes.

---

## Milestones

| Phase     | Deliverable                      | Components                              |
| --------- | -------------------------------- | --------------------------------------- |
| 0 ✅      | Theme tokens incl. `--sidebar-*` | (shipped in the OKLCH migration)        |
| 1 ✅      | Quick wins                       | `skeleton`, `collapsible`, `breadcrumb` |
| 2 ✅      | Off-canvas                       | `sheet`                                 |
| 3 ✅      | The primitive                    | `sidebar` (compound)                    |
| 4 ✅      | First block (website demo)       | `sidebar-08` page + `/blocks` gallery   |
| 5 (later) | Installable blocks               | `blocks/` registry type + CLI           |

## Per-component checklist (every PR)

- [ ] Anonymous Blade, `@props` with defaults; multi-part components ship as
      multiple `files[]` in one registry entry (Blade namespace).
- [ ] `variant`/`size` naming, inline `match()`, `default` arm.
- [ ] classes through `TailwindMerge::merge(...)`, consumer `class` last;
      `$attributes->except('class')->merge(...)` on the root.
- [ ] theme tokens only (sidebar parts use `--sidebar-*`); no hardcoded colors.
- [ ] semantic markup + ARIA + keyboard + focus management.
- [ ] Alpine only if unavoidable, inline `x-data`, declared in `dependencies.js`.
- [ ] `component.json` validates against `registry/schema.json`.
- [ ] `php registry/build.php` run; `index.json` in sync.
- [ ] dogfood-installed/copied into `website/` for parity; `npm run build`.
- [ ] `./vendor/bin/pest` green (add `SmokeRenderTest` cases for new parts).

## Phase 5 detail — installable `blocks/` registry type

When we promote blocks from website demos to installable artifacts:

- New `registry/blocks/<name>/block.json` (`type: "block"`) with `files[]` (target
  paths under the consumer's views) and `registryDependencies` (component names).
- Extend `RegistryClient` to read blocks, `DependencyResolver` to resolve a block's
  component deps (logic already recursive/deduped), `FileInstaller` to write block
  files to their targets. `index.json` gains a `blocks` array; update
  `registry/schema.json` + `SchemaValidationTest`.
- `php artisan ui:add sidebar-08` then installs the block and every missing
  underlying component in one shot — the shadcn experience.
