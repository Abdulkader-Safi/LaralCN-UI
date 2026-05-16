# Component Authoring Standard

Every LaralCN-UI component **must** follow this standard. Consistency here is what separates a real system from a pile of snippets (PRD §7.2). Deviation is a bug.

A component is judged against this file in review. If it breaks a MUST, it does not ship.

## 1. Form

- **MUST** be an anonymous Blade component: a single `.blade.php` file, no PHP class, no Composer autoloading.
- **MUST** declare every input via `@props([...])` with explicit defaults.
- **MUST** be fully self-contained. The only external symbol a component may reference is `\TailwindMerge\Laravel\Facades\TailwindMerge`. No project helper, no shared trait, no base component. (A copied-from-website file must work with nothing but Tailwind v4 + `gehrisandro/tailwind-merge-laravel` installed.)

## 2. Variants (locked convention, see DECISIONS D3)

- Variant prop is always named `variant`. Size prop is always named `size`. Never `type`, `intent`, `color`, `kind`.
- Variant resolution is an inline `@php` block using `match()`. No `cva`, no helper, no config lookup.
- Every `match()` **MUST** have a `default` arm, it is the fallback, and it is the value of the `default` prop default.
- Required structure:

```blade
@props(["variant" => "default", "size" => "md"])

@php
  $base = "inline-flex items-center justify-center ...";

  $variants = match ($variant) {
      "destructive"
          => "bg-destructive text-destructive-foreground hover:bg-destructive/90",
      "outline" => "border border-input bg-background hover:bg-accent",
      "secondary"
          => "bg-secondary text-secondary-foreground hover:bg-secondary/80",
      "ghost" => "hover:bg-accent hover:text-accent-foreground",
      "link" => "text-primary underline-offset-4 hover:underline",
      default => "bg-primary text-primary-foreground hover:bg-primary/90",
  };

  $sizes = match ($size) {
      "sm" => "h-9 px-3 text-sm",
      "lg" => "h-11 px-8",
      "icon" => "h-10 w-10",
      default => "h-10 px-4 py-2 text-sm",
  };

  $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
      $base,
      $variants,
      $sizes,
      $attributes->get("class"),
  );
@endphp

<button {{ $attributes->except("class")->merge(["class" => $classes]) }}>
  {{ $slot }}
</button>
```

## 3. Class merging (locked, see DECISIONS D2)

- The component's own classes, the variant/size strings, and the consumer's `class` attribute **MUST** all pass through `TailwindMerge::merge(...)` in that order (consumer `class` last so it wins).
- Render attributes with `{{ $attributes->except('class')->merge(['class' => $classes]) }}` so the merged result is not re-concatenated with the raw `class`.
- Components **MUST NOT** ship a stylesheet. Styling is Tailwind utilities + theme CSS variables only.

## 4. Theming

- Colors, radius, and spacing **MUST** come from theme tokens (`bg-primary`, `text-muted-foreground`, `rounded-md`, etc.), never hardcoded hex/rgb. Theming a project must require zero edits to component files. The token set is defined once by `ui:init` / the theming page. Components only consume tokens; they never define them.

## 5. Accessibility (MUST)

- Correct semantic element (`<button>`, `<label>`, `<table>`, `<dialog>`-pattern, etc.). No `<div>` where a real element exists.
- Interactive components: full keyboard support (Tab, Enter/Space, Esc where it applies, arrow keys for menus/tabs).
- Overlays (dialog, dropdown, tooltip): manage focus, trap focus while open, restore focus to the trigger on close, `Esc` closes, `aria-*` wired (`role`, `aria-modal`, `aria-expanded`, `aria-controls`, `aria-labelledby`).
- Form controls: associate labels, expose `aria-invalid`/`aria-describedby` where relevant, never remove focus outlines without an equivalent.

## 6. Interactivity

- Zero JavaScript unless interactivity is genuinely unavoidable.
- When needed, use **Alpine.js**, inline via `x-data` on the component root, so the file stays self-contained. No external JS file, no Alpine component registered elsewhere.
- A component that needs Alpine **MUST** list `alpinejs` in its registry entry's `dependencies.js` and state it in its docs.

## 7. Registry entry

Every component ships with `registry/components/<name>/component.json` that validates against `registry/schema.json`, plus its file(s) under `files/`. `dependencies.composer` **MUST** include `gehrisandro/tailwind-merge-laravel` for any component that uses the merge (i.e. effectively all of them).

## 8. Checklist (every PR)

- [ ] Anonymous component, `@props` with defaults
- [ ] `variant`/`size` naming, inline `match()`, `default` arm present
- [ ] classes flow through `TailwindMerge::merge(...)`, consumer `class` last
- [ ] `$attributes->except('class')->merge(...)` on the root element
- [ ] only theme tokens, no hardcoded colors, no stylesheet
- [ ] semantic markup + ARIA + keyboard + focus management
- [ ] Alpine only if unavoidable, inline `x-data`, declared in registry
- [ ] `component.json` validates against `schema.json`
- [ ] no reference to any symbol other than `TailwindMerge`
