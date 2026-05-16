<?php

declare(strict_types=1);

namespace Safi\LaralcnUi\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Safi\LaralcnUi\Console\Concerns\InteractsWithProject;
use Throwable;

final class DiffCommand extends Command
{
    use InteractsWithProject;

    protected $signature = "ui:diff {component? : Component to diff; omit to diff every installed component}";

    protected $description = "Show how your local components differ from the current registry version.";

    public function handle(Filesystem $files): int
    {
        $registry = $this->registry();
        $base = $this->componentsBasePath();

        try {
            if ($name = $this->argument("component")) {
                $names = [$name];
            } else {
                $names = array_column(
                    $registry->index()["components"] ?? [],
                    "name",
                );
            }
        } catch (Throwable $e) {
            $this->components->error($e->getMessage());

            return self::FAILURE;
        }

        $anyDrift = false;

        foreach ($names as $componentName) {
            try {
                $entry = $registry->component($componentName);
            } catch (Throwable $e) {
                $this->components->error($e->getMessage());

                return self::FAILURE;
            }

            foreach ($entry["files"] as $file) {
                $target = $base . "/" . ltrim($file["path"], "/");

                if (!$files->exists($target)) {
                    continue;
                }

                $local = $files->get($target);
                $remote = $registry->fileContents(
                    $componentName,
                    $file["source"],
                );

                if ($local === $remote) {
                    continue;
                }

                $anyDrift = true;
                $this->newLine();
                $this->components->info($componentName . " › " . $file["path"]);
                $this->renderDiff($local, $remote);
            }
        }

        if (!$anyDrift) {
            $this->components->info(
                "Everything is up to date with the registry.",
            );
        }

        return self::SUCCESS;
    }

    private function renderDiff(string $local, string $remote): void
    {
        $a = explode("\n", $local);
        $b = explode("\n", $remote);
        $max = max(count($a), count($b));

        for ($i = 0; $i < $max; $i++) {
            $left = $a[$i] ?? null;
            $right = $b[$i] ?? null;

            if ($left === $right) {
                continue;
            }

            if ($left !== null) {
                $this->line("<fg=red>- " . $left . "</>");
            }

            if ($right !== null) {
                $this->line("<fg=green>+ " . $right . "</>");
            }
        }
    }
}
