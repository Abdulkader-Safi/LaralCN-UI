<?php

declare(strict_types=1);

use Illuminate\Filesystem\Filesystem;
use Safi\LaralcnUi\Registry\DependencyResolver;
use Safi\LaralcnUi\Registry\RegistryClient;

beforeEach(function () {
    $this->files = new Filesystem();
});

it("resolves dialog with button first (install order)", function () {
    $resolver = new DependencyResolver(
        new RegistryClient($this->registryPath(), $this->files),
    );

    $resolved = $resolver->resolve(["dialog"]);

    expect(array_column($resolved["components"], "name"))->toBe([
        "button",
        "dialog",
    ]);
    expect($resolved["js"])->toContain("alpinejs");
});

it("ui:add dialog also installs the button dependency", function () {
    $this->artisan("ui:add", ["component" => ["dialog"]])
        ->expectsOutputToContain("Including required components: button")
        ->assertSuccessful();

    expect(
        $this->files->exists($this->sandboxPath("components/button.blade.php")),
    )->toBeTrue();
    expect(
        $this->files->exists($this->sandboxPath("components/dialog.blade.php")),
    )->toBeTrue();
});

it("reports the alpine npm dependency the user must install", function () {
    $this->artisan("ui:add", ["component" => ["dialog"]])
        ->expectsOutputToContain("npm install")
        ->assertSuccessful();
});

it("lists components grouped by category", function () {
    $this->artisan("ui:list")
        ->expectsOutputToContain("Forms")
        ->expectsOutputToContain("Overlays")
        ->assertSuccessful();
});
