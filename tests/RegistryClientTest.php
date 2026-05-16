<?php

declare(strict_types=1);

use Illuminate\Filesystem\Filesystem;
use Safi\LaralcnUi\Registry\RegistryClient;

beforeEach(function () {
    $this->registry = new RegistryClient(
        $this->registryPath(),
        new Filesystem(),
    );
});

it("treats a filesystem path as a local registry", function () {
    expect($this->registry->isLocal())->toBeTrue();
});

it("reads the index catalogue", function () {
    $index = $this->registry->index();

    expect($index["components"])->toBeArray();
    expect(array_column($index["components"], "name"))->toContain("button");
});

it("reads a single component entry", function () {
    $entry = $this->registry->component("button");

    expect($entry["name"])->toBe("button");
    expect($entry["files"][0]["source"])->toBe("files/button.blade.php");
    expect($entry["dependencies"]["composer"])->toContain(
        "gehrisandro/tailwind-merge-laravel",
    );
});

it("reads raw component file contents", function () {
    $contents = $this->registry->fileContents(
        "button",
        "files/button.blade.php",
    );

    expect($contents)->toContain("@props(")->toContain("TailwindMerge::merge");
});

it("throws for a missing component", function () {
    $this->registry->component("does-not-exist");
})->throws(RuntimeException::class);
