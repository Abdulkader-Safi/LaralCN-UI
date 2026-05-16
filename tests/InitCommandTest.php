<?php

declare(strict_types=1);

use Illuminate\Filesystem\Filesystem;
use Safi\LaralcnUi\Support\ThemeInjector;

beforeEach(function () {
    $this->files = new Filesystem();
});

it("creates the components directory and injects theme variables", function () {
    $this->artisan("ui:init")->assertSuccessful();

    expect(
        $this->files->isDirectory($this->sandboxPath("components")),
    )->toBeTrue();

    $css = $this->sandboxPath("app.css");
    expect($this->files->exists($css))->toBeTrue();
    expect($this->files->get($css))
        ->toContain(ThemeInjector::START)
        ->toContain("--primary")
        ->toContain("@theme inline");
});

it("is idempotent across repeated runs", function () {
    $this->artisan("ui:init")->assertSuccessful();
    $this->artisan("ui:init")->assertSuccessful();

    $contents = $this->files->get($this->sandboxPath("app.css"));

    expect(substr_count($contents, ThemeInjector::START))->toBe(1);
    expect(substr_count($contents, ThemeInjector::END))->toBe(1);
});
