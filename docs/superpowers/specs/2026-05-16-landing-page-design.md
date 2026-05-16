# Landing page + components route, design

Date: 2026-05-16

## Goal

Move the existing components grid off `/` onto its own route, and make `/`
a marketing landing page about LaralCN-UI.

## Routing (`website/routes/web.php`)

- `/` → `DocsController@home`, route name `home`
- `/components` → existing index logic, route name **kept** as `docs.index`
  (so all `route('docs.index')` references keep resolving; only the URL moves)

## Controller (`DocsController`)

Add `home(): View` returning `view('landing', [...])` with:

- `categories`: `$this->registry->byCategory()` (feeds the app layout sidebar)
- `total`: `$this->registry->all()->count()`
- `showcase`: `['button','card','badge']` filtered through `byCategory`/`all`
  so the showcase section can link each to `docs.show` and `@include` its preview.

`index()` is unchanged.

## View `website/resources/views/landing.blade.php`

Wrapped in `<x-layouts.app :all="$categories" title="Laravel + Blade components you own">`.
Sidebar stays populated (consistent site chrome). Main column sections:

1. **Hero + install**: headline, subhead referencing `{{ $total }}` components,
   the `composer require` / `ui:init` / `ui:add button` snippet (same card styling
   as the current index), CTAs: "Browse components" → `route('docs.index')`,
   "GitHub" → repo URL.
2. **Why / features**: grid of feature cards: copy-and-own (no runtime lib),
   pure Blade + Tailwind v4, Alpine only when interactivity is unavoidable,
   recursive dependency resolver via the CLI.
3. **Component showcase**: for each name in `$showcase`, a bordered card that
   `@include('previews.'.$name)` and links to `route('docs.show', $name)`.
  4. **Footer**: links: Components, Theming, Plain Blade, GitHub, Packagist.

## Layout header (`components/layouts/app.blade.php`)

Logo link changes from `route('docs.index')` to `route('home')`. Add a
"Components" nav link → `route('docs.index')` so the grid stays reachable.

## Tests (`website/tests/Feature/LandingTest.php`)

- `GET /` → 200, contains landing hero copy (e.g. "copy-and-own").
- `GET /components` → 200, contains a known component name.

Existing tests using `route('docs.index')` keep passing (name preserved).

## Out of scope

No new layout, no design-system changes, no content for routes other than the
two above.
