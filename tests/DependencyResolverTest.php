<?php

declare(strict_types=1);

use Illuminate\Filesystem\Filesystem;
use Safi\LaralcnUi\Registry\DependencyResolver;
use Safi\LaralcnUi\Registry\RegistryClient;

beforeEach(function () {
    $this->resolver = new DependencyResolver(
        new RegistryClient($this->registryPath(), new Filesystem()),
    );
});

it("resolves a leaf component to just itself", function () {
    $resolved = $this->resolver->resolve(["button"]);

    expect(array_column($resolved["components"], "name"))->toBe(["button"]);
});

it("aggregates composer dependencies across the closure", function () {
    $resolved = $this->resolver->resolve(["button"]);

    expect($resolved["composer"])->toContain(
        "gehrisandro/tailwind-merge-laravel",
    );
});

it("deduplicates when a component is requested twice", function () {
    $resolved = $this->resolver->resolve(["button", "button"]);

    expect(array_column($resolved["components"], "name"))->toBe(["button"]);
});
