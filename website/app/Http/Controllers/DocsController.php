<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\BladeDoc;
use App\Support\DocsMarkdown;
use App\Support\Registry;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class DocsController extends Controller
{
    public function __construct(
        private readonly Registry $registry,
        private readonly DocsMarkdown $markdown,
    ) {}

    public function home(): View
    {
        $showcase = ["button", "card", "badge"];

        return view("landing", [
            "categories" => $this->registry->byCategory(),
            "total" => $this->registry->all()->count(),
            "showcase" => $this->registry
                ->all()
                ->whereIn("name", $showcase)
                ->sortBy(
                    fn(array $c) => array_search($c["name"], $showcase, true),
                )
                ->values(),
        ]);
    }

    public function index(): View
    {
        return view("docs.index", [
            "categories" => $this->registry->byCategory(),
            "total" => $this->registry->all()->count(),
        ]);
    }

    public function show(string $name): View
    {
        $entry = $this->registry->find($name);

        if ($entry === null) {
            throw new NotFoundHttpException("Unknown component [{$name}].");
        }

        $files = array_map(
            fn(array $file) => [
                "path" => $file["path"],
                "code" => $this->registry->source($name, $file["source"]),
            ],
            $entry["files"],
        );

        return view("docs.show", [
            "entry" => $entry,
            "source" => $files[0]["code"] ?? "",
            "files" => $files,
            "command" => $this->registry->command($name),
            "demoView" => "examples.{$name}",
            "hasDemo" => view()->exists("examples.{$name}"),
            "demoSource" => $this->exampleSource("{$name}.blade.php"),
            "usageSource" => $this->exampleSource("{$name}.usage.blade.php"),
            "propsSource" => BladeDoc::props($files[0]["code"] ?? ""),
            "all" => $this->registry->byCategory(),
        ]);
    }

    public function blocksIndex(): View
    {
        return view("docs.blocks", [
            "all" => $this->registry->byCategory(),
            "blocks" => $this->registry->blocksByCategory(),
            "total" => $this->registry->blocks()->count(),
        ]);
    }

    public function blockShow(string $slug): View
    {
        $entry = $this->registry->findBlock($slug);

        if ($entry === null) {
            throw new NotFoundHttpException("Unknown block [{$slug}].");
        }

        $files = array_map(
            fn(array $file) => [
                "path" => $file["path"],
                "code" => $this->registry->blockSource($slug, $file["source"]),
            ],
            $entry["files"],
        );

        return view("docs.block-show", [
            "all" => $this->registry->byCategory(),
            "entry" => $entry,
            "files" => $files,
            "source" => $files[0]["code"] ?? "",
            "command" => $this->registry->blockCommand($slug),
            "previewUrl" => route("blocks.preview", $slug),
            "propsSource" => BladeDoc::props($files[0]["code"] ?? ""),
            "usageSource" => BladeDoc::usage($files[0]["code"] ?? ""),
            "usageNotes" => BladeDoc::notes($files[0]["code"] ?? ""),
        ]);
    }

    public function blockPreview(string $slug): View
    {
        $entry = $this->registry->findBlock($slug);

        if ($entry === null) {
            throw new NotFoundHttpException("Unknown block [{$slug}].");
        }

        $source = $this->registry->blockSource(
            $slug,
            $entry["files"][0]["source"] ?? "",
        );

        return view("docs.block-preview", [
            "slug" => $slug,
            "title" => $entry["name"],
            "source" => $source,
        ]);
    }

    public function gettingStarted(): View
    {
        $entry = $this->registry->find("button");

        return view("docs.getting-started", [
            "all" => $this->registry->byCategory(),
            "entry" => $entry,
            "source" =>
                $entry === null
                    ? ""
                    : $this->registry->source(
                        "button",
                        $entry["files"][0]["source"],
                    ),
            "command" => $this->registry->command("button"),
            "demoView" => "examples.button",
            "hasDemo" => view()->exists("examples.button"),
        ]);
    }

    public function theming(): View
    {
        return view("docs.theming", [
            "theme" => $this->registry->themeCss(),
            "all" => $this->registry->byCategory(),
        ]);
    }

    public function plainBlade(): View
    {
        return view("docs.plain-blade", [
            "all" => $this->registry->byCategory(),
        ]);
    }

    // The Markdown channel: /llms.txt plus a .md twin of every page above,
    // so an agent can read the docs without parsing HTML.

    public function llms(): Response
    {
        return $this->plain($this->markdown->llms());
    }

    public function llmsFull(): Response
    {
        return $this->plain($this->markdown->full());
    }

    public function indexMarkdown(): Response
    {
        return $this->plain($this->markdown->componentsIndex());
    }

    public function showMarkdown(string $name): Response
    {
        $markdown = $this->markdown->component($name);

        if ($markdown === null) {
            throw new NotFoundHttpException("Unknown component [{$name}].");
        }

        return $this->plain($markdown);
    }

    public function blocksIndexMarkdown(): Response
    {
        return $this->plain($this->markdown->blocksIndex());
    }

    public function blockShowMarkdown(string $slug): Response
    {
        $markdown = $this->markdown->block($slug);

        if ($markdown === null) {
            throw new NotFoundHttpException("Unknown block [{$slug}].");
        }

        return $this->plain($markdown);
    }

    public function themingMarkdown(): Response
    {
        return $this->plain($this->markdown->themingPage());
    }

    /**
     * Served as text/plain: browsers download text/markdown instead of
     * showing it, and the "view as markdown" link should just render.
     */
    private function plain(string $body): Response
    {
        return response($body, 200, [
            "Content-Type" => "text/plain; charset=utf-8",
        ]);
    }

    /**
     * Raw contents of a website example asset (the rendered demo or the
     * usage boilerplate). These live in the app's view tree, not the
     * registry, so they are read directly. Returns null when absent.
     */
    private function exampleSource(string $relative): ?string
    {
        $path = resource_path("views/examples/" . $relative);

        return is_file($path) ? (string) file_get_contents($path) : null;
    }

}
