<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Renders the docs site a second time, as plain Markdown: an /llms.txt index
 * plus a `.md` twin of every component and block page.
 *
 * Both channels read the same registry the HTML pages read, so the Markdown
 * an agent copies is the same source `php artisan ui:add` installs.
 */
final class DocsMarkdown
{
    public function __construct(private readonly Registry $registry) {}

    /** The llms.txt index: what this is, how to install, every page. */
    public function llms(): string
    {
        $lines = [
            "# LaralCN-UI",
            "",
            "> A shadcn-style, copy-and-own component system for Laravel and Blade. There is no runtime component library: `safi/laralcn-ui` is a CLI that copies plain `.blade.php` files into your own `resources/views/components/ui/` directory, where you own and edit them. Pure Blade + Tailwind v4, Alpine.js only where interactivity needs it.",
            "",
            "## Install",
            "",
            "```bash",
            "composer require --dev safi/laralcn-ui",
            "php artisan ui:init          # injects the theme tokens, creates the components dir",
            "php artisan ui:add button    # copies one component (and its dependencies)",
            "```",
            "",
            "## Conventions",
            "",
            "- Every component is an anonymous Blade component under `resources/views/components/ui/`, used as `<x-ui.button>`. Multi-file components are namespaced directories: `<x-ui.pagination.item>`.",
            "- Variants and sizes are always the props `variant` and `size`, resolved with an inline `match()` in the file itself. No `cva`, no shared helper.",
            "- Classes you pass through `class=\"...\"` win over the component's own classes: each component funnels base + variant + your `class` through `TailwindMerge::merge(...)`.",
            "- The only external symbol a component file uses is `\\TailwindMerge\\Laravel\\Facades\\TailwindMerge`. Each file is standalone, so copy-pasting one from this site works with no other setup.",
            "- Colors come from theme tokens (`bg-primary`, `text-muted-foreground`, `--radius`), never hardcoded values. Tailwind v4 CSS-first only, there is no `tailwind.config.js`.",
            "",
            "## Guides",
            "",
            "- [Getting started](" .
            route("docs.getting-started") .
            "): install the CLI, add your first component.",
            "- [Theming](" .
            route("docs.theming.md") .
            "): the CSS variables every component reads, light and dark.",
            "- [Plain Blade](" .
            route("docs.plain-blade") .
            "): using the components without the CLI.",
            "",
            "## Components",
            "",
        ];

        foreach ($this->registry->all() as $component) {
            $lines[] = sprintf(
                "- [%s](%s): %s",
                $component["name"],
                route("docs.show.md", $component["name"]),
                $component["description"],
            );
        }

        $lines[] = "";
        $lines[] = "## Blocks";
        $lines[] = "";
        $lines[] =
            "Full sections assembled from the components above, installed with `php artisan ui:add-block <name>`.";
        $lines[] = "";

        foreach ($this->registry->blocks() as $block) {
            $lines[] = sprintf(
                "- [%s](%s): %s",
                $block["name"],
                route("blocks.show.md", $block["name"]),
                $block["description"],
            );
        }

        $lines[] = "";
        $lines[] = "## Optional";
        $lines[] = "";
        $lines[] =
            "- [llms-full.txt](" .
            route("llms.full") .
            "): every page above concatenated into one file, source included.";
        $lines[] = "";

        return implode("\n", $lines);
    }

    /** The /components page. */
    public function componentsIndex(): string
    {
        $lines = [
            ...$this->frontmatter(
                "Components",
                "Every component in LaralCN-UI. Copy one into your project, or install it with the CLI.",
            ),
            "# Components",
            "",
            sprintf(
                "%d components, grouped by category. Each links to its Markdown page: description, install command, dependencies, usage, and the full Blade source.",
                $this->registry->all()->count(),
            ),
            "",
        ];

        foreach ($this->registry->byCategory() as $category => $items) {
            $lines[] = "## {$category}";
            $lines[] = "";

            foreach ($items as $item) {
                $lines[] = sprintf(
                    "- [%s](%s): %s",
                    $item["name"],
                    route("docs.show.md", $item["name"]),
                    $item["description"],
                );
            }

            $lines[] = "";
        }

        return implode("\n", $lines);
    }

    /** One component page, or null when the component does not exist. */
    public function component(string $name): ?string
    {
        $entry = $this->registry->find($name);

        if ($entry === null) {
            return null;
        }

        $lines = [
            ...$this->frontmatter(
                $entry["name"],
                $entry["description"],
                $entry["category"] ?? null,
            ),
            "# {$entry["name"]}",
            "",
            $entry["description"],
            "",
            "## Installation",
            "",
            "```bash",
            $this->registry->command($entry["name"]),
            "```",
            "",
            ...$this->dependencies($entry),
        ];

        $usage = $this->example("{$name}.usage.blade.php");

        if ($usage !== null) {
            $lines = [...$lines, "## Usage", "", ...$this->code($usage)];
        }

        $demo = $this->example("{$name}.blade.php");

        if ($demo !== null) {
            $lines = [
                ...$lines,
                "## Example",
                "",
                "The demo rendered on the docs page.",
                "",
                ...$this->code($demo),
            ];
        }

        $lines[] = "## Source";
        $lines[] = "";
        $lines[] =
            count($entry["files"]) > 1
                ? "Copy each file to the path shown above it."
                : "Copy this file to the path shown above it.";
        $lines[] = "";

        foreach ($entry["files"] as $file) {
            $lines[] = "`resources/views/components/ui/{$file["path"]}`";
            $lines[] = "";
            $lines = [
                ...$lines,
                ...$this->code(
                    $this->registry->source($entry["name"], $file["source"]),
                ),
            ];
        }

        return implode("\n", [...$lines, ...$this->theming($entry)]);
    }

    /** The /blocks page. */
    public function blocksIndex(): string
    {
        $lines = [
            ...$this->frontmatter(
                "Blocks",
                "Full sections built from LaralCN-UI components: navbars, sidebars, app shells.",
            ),
            "# Blocks",
            "",
            "Ready-made sections assembled from the components. `php artisan ui:add-block <name>` installs the block and every component it needs.",
            "",
        ];

        foreach ($this->registry->blocksByCategory() as $category => $items) {
            $lines[] = "## {$category}";
            $lines[] = "";

            foreach ($items as $item) {
                $lines[] = sprintf(
                    "- [%s](%s): %s",
                    $item["name"],
                    route("blocks.show.md", $item["name"]),
                    $item["description"],
                );
            }

            $lines[] = "";
        }

        return implode("\n", $lines);
    }

    /** One block page, or null when the block does not exist. */
    public function block(string $slug): ?string
    {
        $entry = $this->registry->findBlock($slug);

        if ($entry === null) {
            return null;
        }

        $lines = [
            ...$this->frontmatter(
                $entry["name"],
                $entry["description"],
                $entry["category"] ?? null,
            ),
            "# {$entry["name"]}",
            "",
            $entry["description"],
            "",
            "## Installation",
            "",
            "```bash",
            $this->registry->blockCommand($entry["name"]),
            "```",
            "",
            ...$this->dependencies($entry),
            "## Source",
            "",
        ];

        foreach ($entry["files"] as $file) {
            $lines[] = "`resources/views/components/ui/{$file["path"]}`";
            $lines[] = "";
            $lines = [
                ...$lines,
                ...$this->code(
                    $this->registry->blockSource(
                        $entry["name"],
                        $file["source"],
                    ),
                ),
            ];
        }

        return implode("\n", $lines);
    }

    /** The theme tokens every component reads. */
    public function themingPage(): string
    {
        return implode("\n", [
            ...$this->frontmatter(
                "Theming",
                "The CSS variables every LaralCN-UI component reads, in light and dark.",
            ),
            "# Theming",
            "",
            "`php artisan ui:init` writes this block into your `resources/css/app.css` between sentinel comments, so re-running it updates the theme in place. Components only ever read these tokens, so changing a value here restyles every component at once.",
            "",
            "```css",
            trim($this->registry->themeCss()),
            "```",
            "",
        ]);
    }

    /** Every page above in one file, for pasting into an agent's context. */
    public function full(): string
    {
        $pages = [
            $this->llms(),
            $this->themingPage(),
            $this->componentsIndex(),
        ];

        foreach ($this->registry->all() as $component) {
            $pages[] = $this->component($component["name"]);
        }

        $pages[] = $this->blocksIndex();

        foreach ($this->registry->blocks() as $block) {
            $pages[] = $this->block($block["name"]);
        }

        return implode("\n\n---\n\n", array_filter($pages));
    }

    /** @return list<string> */
    private function frontmatter(
        string $title,
        string $description,
        ?string $category = null,
    ): array {
        $lines = [
            "---",
            "title: " . json_encode($title),
            "description: " . json_encode($description),
        ];

        if ($category !== null) {
            $lines[] = "category: " . json_encode($category);
        }

        return [...$lines, "---", ""];
    }

    /**
     * @param  array<string, mixed>  $entry
     * @return list<string>
     */
    private function dependencies(array $entry): array
    {
        $composer = $entry["dependencies"]["composer"] ?? [];
        $js = $entry["dependencies"]["js"] ?? [];
        $components = $entry["dependencies"]["components"] ?? [];

        if (!$composer && !$js && !$components) {
            return ["## Dependencies", "", "None.", ""];
        }

        $lines = ["## Dependencies", ""];

        foreach ($composer as $dep) {
            $lines[] = "- composer: `{$dep}`";
        }

        foreach ($js as $dep) {
            $lines[] = "- npm: `{$dep}`";
        }

        foreach ($components as $dep) {
            $lines[] = "- component: [{$dep}](" .
                route("docs.show.md", $dep) .
                ") — the CLI installs it for you.";
        }

        return [...$lines, ""];
    }

    /**
     * @param  array<string, mixed>  $entry
     * @return list<string>
     */
    private function theming(array $entry): array
    {
        $vars = $entry["tailwind"]["cssVars"] ?? [];
        $notes = $entry["tailwind"]["notes"] ?? null;

        if (!$vars && !$notes) {
            return [];
        }

        $lines = ["## Theme tokens", ""];

        if ($vars) {
            $lines[] = implode(
                ", ",
                array_map(static fn(string $v) => "`{$v}`", $vars),
            );
            $lines[] = "";
        }

        if ($notes) {
            $lines[] = $notes;
            $lines[] = "";
        }

        return $lines;
    }

    /** @return list<string> */
    private function code(string $source): array
    {
        return ["```blade", trim($source), "```", ""];
    }

    /**
     * Demo and usage snippets live in the website's view tree, not the
     * registry, so they are read straight off disk.
     */
    private function example(string $relative): ?string
    {
        $path = resource_path("views/examples/" . $relative);

        return is_file($path) ? (string) file_get_contents($path) : null;
    }
}
