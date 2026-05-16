<?php

declare(strict_types=1);

use Illuminate\Filesystem\Filesystem;

beforeEach(function () {
    $this->files = new Filesystem();
    $this->target = $this->sandboxPath("components/button.blade.php");
});

it("writes the requested component into the components path", function () {
    $this->artisan("ui:add", ["component" => ["button"]])->assertSuccessful();

    expect($this->files->exists($this->target))->toBeTrue();
    expect($this->files->get($this->target))
        ->toContain("@props(")
        ->toContain("TailwindMerge::merge");
});

it("skips an identical existing file without prompting", function () {
    $this->artisan("ui:add", ["component" => ["button"]])->assertSuccessful();

    $this->artisan("ui:add", ["component" => ["button"]])
        ->expectsOutputToContain("skipped")
        ->assertSuccessful();
});

it(
    "reports the tailwind-merge composer dependency the user must install",
    function () {
        $this->artisan("ui:add", ["component" => ["button"]])
            ->expectsOutputToContain("gehrisandro/tailwind-merge-laravel")
            ->assertSuccessful();
    },
);

it("keeps a locally edited file when the user chooses skip", function () {
    $this->files->ensureDirectoryExists(dirname($this->target));
    $this->files->put($this->target, "{{-- my local edits --}}");

    $this->artisan("ui:add", ["component" => ["button"]])
        ->expectsChoice("What would you like to do?", "skip", [
            "skip",
            "overwrite",
            "diff",
        ])
        ->assertSuccessful();

    expect($this->files->get($this->target))->toBe("{{-- my local edits --}}");
});

it("overwrites without prompting when --overwrite is passed", function () {
    $this->files->ensureDirectoryExists(dirname($this->target));
    $this->files->put($this->target, "{{-- my local edits --}}");

    $this->artisan("ui:add", [
        "component" => ["button"],
        "--overwrite" => true,
    ])->assertSuccessful();

    expect($this->files->get($this->target))->toContain("TailwindMerge::merge");
});
