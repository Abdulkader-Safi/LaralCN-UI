# Contributing to LaralCN-UI

Thanks for helping build LaralCN-UI. Read this and `docs/DECISIONS.md` before opening a PR — the architectural calls there are locked and not up for debate inside a feature PR.

## Repository layout

| Path                | What                                                |
| ------------------- | --------------------------------------------------- |
| `packages/blade-ui` | the `safi/laralcn-ui` installer package + CLI       |
| `registry/`         | single source of truth: component JSON + sources    |
| `website/`          | Laravel docs/showcase app (dogfoods the components) |
| `docs/`             | `DECISIONS.md` (locked calls), `AUTHORING.md`       |

## Adding a component

1. Create `registry/components/<name>/`:
   - `component.json` — must validate against `registry/schema.json`.
   - `files/<name>.blade.php` — authored per **`docs/AUTHORING.md`** (no exceptions: inline `match()` variants, classes through `TailwindMerge::merge`, theme tokens only, accessible, self-contained).
2. Regenerate the catalogue: `php registry/build.php` (never hand-edit `registry/index.json`).
3. Add a live preview at `website/resources/views/previews/<name>.blade.php`.
4. Run the package test suite (below). Add tests if your component introduces new dependency-resolution or CLI behavior.
5. Open a PR. CI validates the schema, the index, and the test suite.

`dependencies.composer` must include `gehrisandro/tailwind-merge-laravel` for any component using the class merge (effectively all of them). Declare any Alpine plugin in `dependencies.js`.

## Running tests

```bash
cd packages/blade-ui
composer install
composer test          # or ./vendor/bin/pest
```

## Verifying the website locally

```bash
cd website
composer install && npm install
echo "LARALCN_UI_REGISTRY_URL=$(cd ../registry && pwd)" >> .env
php artisan ui:init
php artisan ui:add button   # dogfood any component you changed
npm run build && php artisan serve
```

## Standards

- PHP: `declare(strict_types=1)`, typed signatures.
- Components: every box on the `docs/AUTHORING.md` checklist must be ticked.
- Keep components self-contained — the only external symbol allowed is `\TailwindMerge\Laravel\Facades\TailwindMerge`.

## License

By contributing you agree your work is released under the MIT License.
