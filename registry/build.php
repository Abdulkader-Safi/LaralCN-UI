<?php

declare(strict_types=1);

/**
 * Assembles registry/index.json from every registry/components/<name>/component.json
 * and registry/blocks/<name>/component.json.
 * Run: php registry/build.php
 *
 * index.json is generated, never hand-edit it (DECISIONS D5).
 */

$root = __DIR__;

$readEntries = static function (string $dir): array {
    $entries = [];

    foreach (glob($dir . "/*/component.json") as $path) {
        $entry = json_decode(
            (string) file_get_contents($path),
            true,
            flags: JSON_THROW_ON_ERROR,
        );

        $entries[] = [
            "name" => $entry["name"],
            "type" => $entry["type"],
            "description" => $entry["description"],
            "category" => $entry["category"],
            "dependencies" => [
                "components" => $entry["dependencies"]["components"] ?? [],
                "js" => $entry["dependencies"]["js"] ?? [],
                "composer" => $entry["dependencies"]["composer"] ?? [],
            ],
        ];
    }

    usort(
        $entries,
        fn(array $a, array $b): int => strcmp($a["name"], $b["name"]),
    );

    return $entries;
};

$components = $readEntries($root . "/components");
$blocks = $readEntries($root . "/blocks");

$index = [
    "name" => "LaralCN-UI",
    "homepage" => "https://github.com/Abdulkader-Safi/LaralCN-UI",
    "schema" => "schema.json",
    "components" => $components,
    "blocks" => $blocks,
];

file_put_contents(
    $root . "/index.json",
    json_encode($index, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL,
);

echo "Wrote index.json with " .
    count($components) .
    " component(s) and " .
    count($blocks) .
    " block(s).\n";
