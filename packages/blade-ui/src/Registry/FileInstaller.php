<?php

declare(strict_types=1);

namespace Safi\LaralcnUi\Registry;

use Closure;
use Illuminate\Filesystem\Filesystem;

/**
 * Writes a set of registry files into the consumer's components_path.
 * Source resolution is delegated to a caller-supplied closure so the same
 * installer serves both components and blocks. On an existing file the
 * conflict decision is delegated to a second closure so the command layer
 * owns the interactive UX.
 */
final class FileInstaller
{
    public function __construct(private readonly Filesystem $files) {}

    /**
     * @param  array<int, array{path: string, source: string}>  $fileEntries
     * @param  Closure(string $source): string  $fetchSource
     *         Returns the raw incoming contents for a registry source path.
     * @param  Closure(string $targetPath, string $existing, string $incoming): string  $onConflict
     *         Must return 'overwrite' or 'skip'.
     * @return array<int, array{path: string, status: 'written'|'skipped'|'overwritten'}>
     */
    public function install(
        array $fileEntries,
        Closure $fetchSource,
        string $componentsBasePath,
        Closure $onConflict,
    ): array {
        $results = [];

        foreach ($fileEntries as $entry) {
            $incoming = $fetchSource($entry["source"]);
            $target =
                rtrim($componentsBasePath, "/") .
                "/" .
                ltrim($entry["path"], "/");

            if ($this->files->exists($target)) {
                $existing = $this->files->get($target);

                if ($existing === $incoming) {
                    $results[] = ["path" => $target, "status" => "skipped"];

                    continue;
                }

                $decision = $onConflict($target, $existing, $incoming);

                if ($decision !== "overwrite") {
                    $results[] = ["path" => $target, "status" => "skipped"];

                    continue;
                }

                $this->write($target, $incoming);
                $results[] = ["path" => $target, "status" => "overwritten"];

                continue;
            }

            $this->write($target, $incoming);
            $results[] = ["path" => $target, "status" => "written"];
        }

        return $results;
    }

    private function write(string $target, string $contents): void
    {
        $this->files->ensureDirectoryExists(dirname($target));
        $this->files->put($target, $contents);
    }
}
