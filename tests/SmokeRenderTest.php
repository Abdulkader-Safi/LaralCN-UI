<?php

declare(strict_types=1);

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;

beforeEach(function () {
    $this->files = new Filesystem();

    // Standard Laravel component discovery path: resources/views/components/ui
    // => <x-ui.*>. This mirrors exactly how a real consumer's project resolves
    // the installed files (config default components_path).
    $this->uiPath = resource_path("views/components/ui");
    $this->files->ensureDirectoryExists($this->uiPath);

    // Install each component the way FileInstaller does: copy every files[].source
    // to files[].path under the components dir. This honours namespaced/multi-file
    // components (e.g. sidebar/*.blade.php => <x-ui.sidebar.*>), not just basenames.
    foreach (
        glob($this->registryPath() . "/components/*/component.json")
        as $manifest
    ) {
        $dir = dirname($manifest);
        $component = json_decode((string) file_get_contents($manifest), true);

        foreach ($component["files"] as $file) {
            $target = $this->uiPath . "/" . ltrim($file["path"], "/");
            $this->files->ensureDirectoryExists(dirname($target));
            $this->files->copy($dir . "/" . $file["source"], $target);
        }
    }
});

afterEach(function () {
    $this->files->deleteDirectory(resource_path("views/components/ui"));
});

it("renders the simple components without errors", function (
    string $tag,
    string $body,
) {
    $html = Blade::render("<x-ui.{$tag}>{$body}</x-ui.{$tag}>");

    expect(trim($html))->not->toBeEmpty();
})->with([
    ["button", "Save"],
    ["badge", "New"],
    ["label", "Email"],
    ["textarea", ""],
    ["select", "<option>One</option>"],
    ["card", "Body"],
    ["alert", "Heads up"],
    ["table", "<tbody><tr><td>x</td></tr></tbody>"],
]);

it("renders self-closing-style components", function (string $tag) {
    $html = Blade::render("<x-ui.{$tag} />");

    expect(trim($html))->not->toBeEmpty();
})->with(["input", "checkbox", "radio", "separator", "avatar", "skeleton"]);

it("renders compound (namespaced, multi-file) components", function (
    string $markup,
) {
    $html = Blade::render($markup);

    expect(trim($html))->not->toBeEmpty();
})->with([
    "collapsible" => [
        "<x-ui.collapsible><x-ui.collapsible.trigger>Toggle</x-ui.collapsible.trigger><x-ui.collapsible.content>Body</x-ui.collapsible.content></x-ui.collapsible>",
    ],
    "breadcrumb" => [
        '<x-ui.breadcrumb><x-ui.breadcrumb.list><x-ui.breadcrumb.item><x-ui.breadcrumb.link href="#">Home</x-ui.breadcrumb.link></x-ui.breadcrumb.item><x-ui.breadcrumb.separator /><x-ui.breadcrumb.item><x-ui.breadcrumb.page>Now</x-ui.breadcrumb.page></x-ui.breadcrumb.item></x-ui.breadcrumb.list></x-ui.breadcrumb>',
    ],
    "sidebar" => [
        '<x-ui.sidebar.provider><x-ui.sidebar><x-ui.sidebar.header>H</x-ui.sidebar.header><x-ui.sidebar.content><x-ui.sidebar.group><x-ui.sidebar.group-label>Group</x-ui.sidebar.group-label><x-ui.sidebar.menu><x-ui.sidebar.menu-item><x-ui.sidebar.menu-button :is-active="true" tooltip="Home" href="#">Home</x-ui.sidebar.menu-button><x-ui.sidebar.menu-badge>3</x-ui.sidebar.menu-badge></x-ui.sidebar.menu-item></x-ui.sidebar.menu></x-ui.sidebar.group></x-ui.sidebar.content><x-ui.sidebar.footer>F</x-ui.sidebar.footer><x-ui.sidebar.rail /></x-ui.sidebar><x-ui.sidebar.inset><x-ui.sidebar.trigger />Main</x-ui.sidebar.inset></x-ui.sidebar.provider>',
    ],
]);

// NOTE: `sheet` (and dialog/dropdown-menu/tooltip/toast) are teleport/Alpine
// overlays — excluded from smoke rendering like the rest of the overlay family;
// their behaviour is exercised in the browser, not Blade::render.

it(
    "lets a consumer class override the built-in one (tailwind-merge works)",
    function () {
        $html = Blade::render('<x-ui.button class="px-10">Go</x-ui.button>');

        expect($html)->toContain("px-10")->not->toContain("px-4"); // built-in default padding was replaced
    },
);

it("applies the destructive variant", function () {
    $html = Blade::render(
        '<x-ui.button variant="destructive">Delete</x-ui.button>',
    );

    expect($html)->toContain("bg-destructive");
});
