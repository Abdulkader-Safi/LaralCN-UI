<?php

declare(strict_types=1);

use Illuminate\Filesystem\Filesystem;
use Safi\LaralcnUi\Support\ThemeInjector;

beforeEach(function () {
    $this->files = new Filesystem();
    $this->css = $this->sandboxPath("app.css");
    $this->injector = new ThemeInjector($this->files);
});

it("creates the css file when it does not exist", function () {
    expect($this->injector->inject($this->css, ":root { --x: 1; }"))->toBe(
        "created",
    );

    expect($this->files->get($this->css))
        ->toContain(ThemeInjector::START)
        ->toContain(ThemeInjector::END)
        ->toContain("--x: 1;");
});

it("is idempotent when re-run with the same theme", function () {
    $this->injector->inject($this->css, ":root { --x: 1; }");

    expect($this->injector->inject($this->css, ":root { --x: 1; }"))->toBe(
        "unchanged",
    );
});

it("replaces only the managed block and keeps surrounding css", function () {
    $this->files->ensureDirectoryExists(dirname($this->css));
    $this->files->put($this->css, "@import \"tailwindcss\";\n");

    $this->injector->inject($this->css, ":root { --x: 1; }");
    $this->injector->inject($this->css, ":root { --x: 2; }");

    $contents = $this->files->get($this->css);

    expect($contents)
        ->toContain('@import "tailwindcss";')
        ->toContain("--x: 2;")
        ->not->toContain("--x: 1;");

    expect(substr_count($contents, ThemeInjector::START))->toBe(1);
});
