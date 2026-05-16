<?php

declare(strict_types=1);

/**
 * Assembles registry/index.json from every registry/components/<name>/component.json.
 * Run: php registry/build.php
 *
 * index.json is generated, never hand-edit it (DECISIONS D5).
 */

$root = __DIR__;
$componentsDir = $root . "/components";

$components = [];

foreach (glob($componentsDir . "/*/component.json") as $path) {
    $entry = json_decode(
        (string) file_get_contents($path),
        true,
        flags: JSON_THROW_ON_ERROR,
    );

    $components[] = [
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
    $components,
    fn(array $a, array $b): int => strcmp($a["name"], $b["name"]),
);

$index = [
    "name" => "LaralCN-UI",
    "homepage" => "https://github.com/Abdulkader-Safi/LaralCN-UI",
    "schema" => "schema.json",
    "components" => $components,
];

file_put_contents(
    $root . "/index.json",
    json_encode($index, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL,
);

echo "Wrote index.json with " . count($components) . " component(s).\n";
