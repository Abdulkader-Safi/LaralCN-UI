<?php

declare(strict_types=1);

/**
 * Every registry/components/<name>/component.json must satisfy the locked
 * schema and stay in sync with the generated index.json (DECISIONS D5).
 */

$registry = dirname(__DIR__).'/registry';

$schema = json_decode((string) file_get_contents($registry.'/schema.json'), true);
$categories = $schema['properties']['category']['enum'];
$types = $schema['properties']['type']['enum'];

$entries = [];
foreach (glob($registry.'/components/*/component.json') as $path) {
    $entries[basename(dirname($path))] = json_decode((string) file_get_contents($path), true);
}

it('has at least the full v1 component set', function () use ($entries) {
    expect(count($entries))->toBeGreaterThanOrEqual(20);
});

dataset('components', array_keys($entries));

it('validates against the registry schema', function (string $name) use ($entries, $categories, $types, $registry) {
    $entry = $entries[$name];

    expect($entry)->toHaveKeys(['name', 'type', 'description', 'category', 'files']);
    expect($entry['name'])->toBe($name);
    expect($entry['name'])->toMatch('/^[a-z][a-z0-9-]*$/');
    expect($entry['type'])->toBeIn($types);
    expect($entry['category'])->toBeIn($categories);
    expect($entry['description'])->toBeString()->not->toBeEmpty();
    expect($entry['files'])->toBeArray()->not->toBeEmpty();

    foreach ($entry['files'] as $file) {
        expect($file)->toHaveKeys(['path', 'source']);
        expect(file_exists($registry."/components/{$name}/".$file['source']))
            ->toBeTrue("missing source file for {$name}");
    }

    expect($entry['dependencies']['composer'] ?? [])
        ->toContain('gehrisandro/tailwind-merge-laravel');
})->with('components');

it('is fully reflected in the generated index.json', function () use ($entries, $registry) {
    $index = json_decode((string) file_get_contents($registry.'/index.json'), true);
    $indexed = array_column($index['components'], 'name');

    sort($indexed);
    $expected = array_keys($entries);
    sort($expected);

    expect($indexed)->toBe($expected);
});
