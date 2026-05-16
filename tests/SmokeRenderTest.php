<?php

declare(strict_types=1);

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;

beforeEach(function () {
    $this->files = new Filesystem;

    // Standard Laravel component discovery path: resources/views/components/ui
    // => <x-ui.*>. This mirrors exactly how a real consumer's project resolves
    // the installed files (config default components_path).
    $this->uiPath = resource_path('views/components/ui');
    $this->files->ensureDirectoryExists($this->uiPath);

    foreach (glob($this->registryPath().'/components/*/files/*.blade.php') as $src) {
        $this->files->copy($src, $this->uiPath.'/'.basename($src));
    }
});

afterEach(function () {
    $this->files->deleteDirectory(resource_path('views/components/ui'));
});

it('renders the simple components without errors', function (string $tag, string $body) {
    $html = Blade::render("<x-ui.{$tag}>{$body}</x-ui.{$tag}>");

    expect(trim($html))->not->toBeEmpty();
})->with([
    ['button', 'Save'],
    ['badge', 'New'],
    ['label', 'Email'],
    ['textarea', ''],
    ['select', '<option>One</option>'],
    ['card', 'Body'],
    ['alert', 'Heads up'],
    ['table', '<tbody><tr><td>x</td></tr></tbody>'],
]);

it('renders self-closing-style components', function (string $tag) {
    $html = Blade::render("<x-ui.{$tag} />");

    expect(trim($html))->not->toBeEmpty();
})->with(['input', 'checkbox', 'radio', 'separator', 'avatar']);

it('lets a consumer class override the built-in one (tailwind-merge works)', function () {
    $html = Blade::render('<x-ui.button class="px-10">Go</x-ui.button>');

    expect($html)
        ->toContain('px-10')
        ->not->toContain('px-4'); // built-in default padding was replaced
});

it('applies the destructive variant', function () {
    $html = Blade::render('<x-ui.button variant="destructive">Delete</x-ui.button>');

    expect($html)->toContain('bg-destructive');
});
