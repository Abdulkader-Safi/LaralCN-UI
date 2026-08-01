<?php

declare(strict_types=1);

use Illuminate\Filesystem\Filesystem;

beforeEach(function () {
    $this->files = new Filesystem();
    $this->blockTarget = $this->sandboxPath(
        "components/blocks/sidebar-01.blade.php",
    );
    $this->componentTarget = $this->sandboxPath(
        "components/sidebar/provider.blade.php",
    );
});

it("writes the block file into components_path/blocks", function () {
    $this->artisan("ui:add-block", ["block" => ["sidebar-01"]])
        ->assertSuccessful();

    expect($this->files->exists($this->blockTarget))->toBeTrue();
    expect($this->files->get($this->blockTarget))->toContain(
        "x-ui.sidebar.provider",
    );
});

it("recursively installs every component the block depends on", function () {
    $this->artisan("ui:add-block", ["block" => ["sidebar-01"]])
        ->assertSuccessful();

    // The block declares 8 component deps, several of which are multi-file
    // (sidebar, breadcrumb, dropdown-menu). Spot-check a representative file
    // from each top-level dep.
    foreach (
        [
            "components/sidebar/provider.blade.php",
            "components/breadcrumb/index.blade.php",
            "components/collapsible/index.blade.php",
            "components/dropdown-menu.blade.php",
            "components/avatar.blade.php",
            "components/separator.blade.php",
            "components/button.blade.php",
            "components/skeleton.blade.php",
        ]
        as $relative
    ) {
        expect(
            $this->files->exists($this->sandboxPath($relative)),
        )->toBeTrue("missing installed file {$relative}");
    }
});

it("reports the manual composer dependencies and no npm ones", function () {
    $this->artisan("ui:add-block", ["block" => ["sidebar-01"]])
        ->expectsOutputToContain("gehrisandro/tailwind-merge-laravel")
        ->doesntExpectOutputToContain("npm install")
        ->assertSuccessful();
});

it("overwrites without prompting when --overwrite is passed", function () {
    $this->files->ensureDirectoryExists(dirname($this->blockTarget));
    $this->files->put($this->blockTarget, "{{-- my local edits --}}");

    $this->artisan("ui:add-block", [
        "block" => ["sidebar-01"],
        "--overwrite" => true,
    ])->assertSuccessful();

    expect($this->files->get($this->blockTarget))->toContain(
        "x-ui.sidebar.provider",
    );
});

it("fails with a clear error when the block is unknown", function () {
    $this->artisan("ui:add-block", ["block" => ["does-not-exist"]])
        ->expectsOutputToContain("does-not-exist")
        ->assertFailed();
});
