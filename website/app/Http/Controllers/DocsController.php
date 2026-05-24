<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\Registry;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class DocsController extends Controller
{
    public function __construct(private readonly Registry $registry) {}

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
            "all" => $this->registry->byCategory(),
        ]);
    }

    /**
     * Blocks gallery. Blocks are multi-component compositions rendered as
     * standalone pages; until the installable `blocks/` registry type lands,
     * each is described here with the components it is composed of and the
     * `ui:add` command that pulls those in.
     */
    public function blocks(): View
    {
        $blocks = [
            [
                "name" => "sidebar-08",
                "title" => "Sidebar 08",
                "category" => "Application Shell",
                "description" =>
                    "A collapsible sidebar with icon mode, mobile off-canvas, a workspace switcher, collapsible nav groups, and a nav-user footer. Ctrl/Cmd-B toggles it.",
                "route" => route("blocks.sidebar-08"),
                "components" => [
                    "sidebar",
                    "breadcrumb",
                    "collapsible",
                    "dropdown-menu",
                    "avatar",
                    "separator",
                    "button",
                    "skeleton",
                ],
                "source" => $this->blockSource("sidebar-08"),
            ],
        ];

        return view("docs.blocks", [
            "all" => $this->registry->byCategory(),
            "blocks" => $blocks,
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

    /**
     * Raw markup of a block's standalone demo view (resources/views/blocks).
     */
    private function blockSource(string $name): string
    {
        $path = resource_path("views/blocks/{$name}.blade.php");

        return is_file($path) ? (string) file_get_contents($path) : "";
    }
}
