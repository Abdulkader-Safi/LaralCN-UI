<?php

declare(strict_types=1);

/**
 * Every registry/components/<name>/component.json and registry/blocks/<name>/component.json
 * must satisfy the locked schema and stay in sync with the generated index.json
 * (DECISIONS D5).
 */

$registry = dirname(__DIR__) . '/registry';

$schema = json_decode((string) file_get_contents($registry . '/schema.json'), true);
$categories = $schema['properties']['category']['enum'];
$types = $schema['properties']['type']['enum'];

$components = [];
foreach (glob($registry . '/components/*/component.json') as $path) {
    $components[basename(dirname($path))] = json_decode((string) file_get_contents($path), true);
}

$blocks = [];
foreach (glob($registry . '/blocks/*/component.json') as $path) {
    $blocks[basename(dirname($path))] = json_decode((string) file_get_contents($path), true);
}

it('has at least the full v1 component set', function () use ($components) {
    expect(count($components))->toBeGreaterThanOrEqual(20);
});

dataset('components', array_keys($components));
dataset('blocks', array_keys($blocks));

it('validates components against the registry schema', function (string $name) use ($components, $categories, $types, $registry) {
    $entry = $components[$name];

    expect($entry)->toHaveKeys(['name', 'type', 'description', 'category', 'files']);
    expect($entry['name'])->toBe($name);
    expect($entry['name'])->toMatch('/^[a-z][a-z0-9-]*$/');
    expect($entry['type'])->toBeIn($types);
    expect($entry['category'])->toBeIn($categories);
    expect($entry['description'])->toBeString()->not->toBeEmpty();
    expect($entry['files'])->toBeArray()->not->toBeEmpty();

    foreach ($entry['files'] as $file) {
        expect($file)->toHaveKeys(['path', 'source']);
        expect(file_exists($registry . "/components/{$name}/" . $file['source']))
            ->toBeTrue("missing source file for {$name}");
    }

    expect($entry['dependencies']['composer'] ?? [])
        ->toContain('gehrisandro/tailwind-merge-laravel');
})->with('components');

it('validates blocks against the registry schema', function (string $name) use ($blocks, $categories, $registry) {
    $entry = $blocks[$name];

    expect($entry)->toHaveKeys(['name', 'type', 'description', 'category', 'files']);
    expect($entry['name'])->toBe($name);
    expect($entry['type'])->toBe('block');
    expect($entry['category'])->toBeIn($categories);
    expect($entry['description'])->toBeString()->not->toBeEmpty();
    expect($entry['files'])->toBeArray()->not->toBeEmpty();

    foreach ($entry['files'] as $file) {
        expect($file)->toHaveKeys(['path', 'source']);
        expect(file_exists($registry . "/blocks/{$name}/" . $file['source']))
            ->toBeTrue("missing source file for block {$name}");
    }

    expect($entry['dependencies']['composer'] ?? [])
        ->toContain('gehrisandro/tailwind-merge-laravel');
})->with('blocks');

it('is fully reflected in the generated index.json', function () use ($components, $blocks, $registry) {
    $index = json_decode((string) file_get_contents($registry . '/index.json'), true);

    $indexedComponents = array_column($index['components'], 'name');
    sort($indexedComponents);
    $expectedComponents = array_keys($components);
    sort($expectedComponents);
    expect($indexedComponents)->toBe($expectedComponents);

    $indexedBlocks = array_column($index['blocks'] ?? [], 'name');
    sort($indexedBlocks);
    $expectedBlocks = array_keys($blocks);
    sort($expectedBlocks);
    expect($indexedBlocks)->toBe($expectedBlocks);
});
