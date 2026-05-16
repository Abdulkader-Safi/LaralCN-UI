<?php

declare(strict_types=1);

namespace Safi\LaralcnUi\Registry;

use RuntimeException;

/**
 * Walks a component's dependency closure: recursively resolves component
 * dependencies into install order (dependencies first), deduplicated, and
 * aggregates the js/composer deps the consumer must install themselves.
 */
final class DependencyResolver
{
    public function __construct(private readonly RegistryClient $registry) {}

    /**
     * @param  array<int, string>  $roots
     * @return array{
     *     components: array<int, array<string, mixed>>,
     *     js: array<int, string>,
     *     composer: array<int, string>
     * }
     */
    public function resolve(array $roots): array
    {
        $ordered = [];
        $entries = [];
        $js = [];
        $composer = [];
        $visiting = [];

        $visit = function (string $name) use (
            &$visit,
            &$ordered,
            &$entries,
            &$js,
            &$composer,
            &$visiting,
        ): void {
            if (isset($entries[$name])) {
                return;
            }

            if (isset($visiting[$name])) {
                throw new RuntimeException(
                    "Circular component dependency detected at [{$name}].",
                );
            }

            $visiting[$name] = true;

            $entry = $this->registry->component($name);
            $deps = $entry["dependencies"] ?? [];

            foreach ($deps["components"] ?? [] as $dependency) {
                $visit($dependency);
            }

            foreach ($deps["js"] ?? [] as $package) {
                $js[$package] = true;
            }

            foreach ($deps["composer"] ?? [] as $package) {
                $composer[$package] = true;
            }

            unset($visiting[$name]);

            $entries[$name] = $entry;
            $ordered[] = $entry;
        };

        foreach ($roots as $root) {
            $visit($root);
        }

        return [
            "components" => $ordered,
            "js" => array_keys($js),
            "composer" => array_keys($composer),
        ];
    }
}
