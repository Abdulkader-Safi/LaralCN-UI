# Plan: Tier A components

> **Status: shipped.** All ten are in the registry, on the website and covered
> by the smoke tests. Two things surfaced during the build that were not in the
> plan: the hover card's inner span needed `block` (width does nothing to an
> inline box), and the carousel's arrows had to scroll to the next item's edge
> rather than by one viewport, because the gap made a viewport-sized step drift
> and skip a slide. Fixing the alert dialog's scrim also turned up a
> pre-existing bug shared by `dialog`, `sheet` and the mobile `sidebar`, see
> AUTHORING §4.

Ten components that close the biggest gaps against shadcn without adding a
dependency or inventing a new pattern. Nine ship zero JavaScript; carousel is
the one exception and it is called out below.

Everything here is judged against `AUTHORING.md`. Nothing in this plan changes
`DECISIONS.md`.

## Per-component work

The same five steps every time. There is no scaffolding command, so this is the
checklist:

1. `registry/components/<name>/files/<name>.blade.php`
2. `registry/components/<name>/component.json` (copy the shape from
   `switch/component.json`, or `collapsible/component.json` for a multi-file one)
3. `php registry/build.php` — regenerates `registry/index.json`, which is what
   drives the website nav. Skipping it fails the registry-integrity CI job.
4. `website/resources/views/examples/<name>.blade.php` — the demo. Add
   `<name>.usage.blade.php` when the demo markup is too long to double as the
   usage snippet (see `table`).
5. A line in `tests/SmokeRenderTest.php`. Which dataset depends on the shape:
   `renders the simple components` (tag + body), `renders self-closing-style`
   (tag only), or `renders compound` (full markup string). The registry glob at
   the top installs new components automatically; only the render assertion is
   manual.

## Wave 1, no surprises

**progress** (Feedback) — `value`, `max`. `role="progressbar"` with
`aria-valuenow/min/max`. Track `relative h-2 w-full overflow-hidden rounded-full
bg-primary/20`, fill `h-full bg-primary transition-all`.
_Gotcha:_ the fill width is dynamic, so it is the one legitimate inline `style`
in the set. A `w-[{{ $pct }}%]` class never reaches Tailwind's scanner and
compiles to nothing.

**aspect-ratio** (Layout) — `ratio` defaulting to `16/9`.
_Gotcha:_ same as above and it is the whole component. `aspect-[{{ $ratio }}]`
does not work; it must be `style="aspect-ratio: {{ $ratio }}"`.

**pagination** (Navigation) — compound: `index`, `content`, `item`, `link`,
`previous`, `next`, `ellipsis`. Mirror `breadcrumb`'s file layout exactly.
`<nav aria-label="pagination">`, `aria-current="page"` on the active link.
Plain markup, so it works with a Laravel paginator or a hand-rolled list. Do not
take a paginator object as a prop; show that wiring in the docs example instead,
so the component stays framework-agnostic.

**toggle** (Forms) — `variant` (default | outline), `size` (sm | md | lg),
`name`, `value`, `pressed`. A `<label>` wrapping a `sr-only` native checkbox,
styled with `has-[:checked]:bg-accent`, exactly the trick `switch` uses. State
is real, submits with the form, needs no script and no `aria-pressed`
bookkeeping.

## Wave 2, browser pseudo-element styling

**slider** (Forms) — native `<input type="range">` with `min`, `max`, `step`,
`value`, `name`, `disabled`.
_Gotcha:_ the thumb needs both `[&::-webkit-slider-thumb]:` and
`[&::-moz-range-thumb]:` arbitrary variants. WebKit also needs
`appearance-none` on the input before any thumb style applies. Budget the time
here on cross-browser checking, not on the Blade.

**scroll-area** (Layout) — `orientation`. Native overflow plus scrollbar
styling; height comes from the consumer's `class`.
_Gotcha:_ two separate styling systems. Firefox reads `scrollbar-width: thin`
and `scrollbar-color`; WebKit reads `::-webkit-scrollbar*` pseudo-elements.
Ship both or it looks unstyled in one of them.

**toggle-group** (Forms) — compound: `index` + `item`. `multiple` boolean, not
a `type` prop: `accordion` already set that precedent and `AUTHORING.md` §2
reserves the `type` name. Single = radio inputs sharing a `name`, multiple =
checkboxes. `role="group"` on the wrapper.

## Wave 3, overlays and motion

**hover-card** (Feedback) — `side`, `align`. Pure CSS, the same `group` +
`group-hover:` + `group-focus-within:` pattern as `tooltip`, with
`transition-delay` for the open delay.
_Gotcha:_ a hover card has to survive the pointer travelling from trigger to
card. Use padding on the wrapper to bridge the gap, never margin on the card;
margin leaves a dead zone that closes it mid-move.

**alert-dialog** (Feedback) — a native `<dialog>`, same shape as `dialog`, but
no X button and no click-outside-to-close: an alert dialog is dismissed by
choosing an action. Esc still closes.
_Gotcha:_ self-containment (§1) means this cannot reuse `dialog`'s script. It
carries its own copy under `data-ui-alert-dialog` names and its own
`window.__laralcnAlertDialog` guard. That duplication is required, not an
oversight.

**carousel** (Data Display) — CSS scroll-snap: track
`overflow-x-auto snap-x snap-mandatory`, items `snap-start shrink-0`. Touch
swipe and keyboard scrolling come free from the platform.
_This is the one Tier A component that ships JavaScript._ Prev/next buttons need
`scrollBy`, roughly fifteen lines, delegated from `document` via
`data-ui-carousel` per §6. Everything else works with the script stripped out.

## Sequencing

Waves are review boundaries, not dependencies. Each is a self-contained batch
that ends with a green `./vendor/bin/pest --no-coverage` and a regenerated
`registry/index.json`.

Deliberately out of scope: `calendar` / `date-picker` (native
`<input type="date">` covers the common case; a real calendar is several hundred
lines of JavaScript) and `chart` (needs a charting library, which §6 forbids).
