<?php

declare(strict_types=1);

namespace Safi\LaralcnUi\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Safi\LaralcnUi\Console\Concerns\InteractsWithProject;
use Throwable;

final class ListCommand extends Command
{
    use InteractsWithProject;

    protected $signature = "ui:list";

    protected $description = "List every available component, grouped by category.";

    public function handle(Filesystem $files): int
    {
        try {
            $index = $this->registry()->index();
        } catch (Throwable $e) {
            $this->components->error($e->getMessage());

            return self::FAILURE;
        }

        $components = $index["components"] ?? [];

        if ($components === []) {
            $this->components->warn("The registry is empty.");

            return self::SUCCESS;
        }

        $base = $this->componentsBasePath();
        $grouped = [];

        foreach ($components as $component) {
            $grouped[$component["category"] ?? "Other"][] = $component;
        }

        ksort($grouped);

        foreach ($grouped as $category => $items) {
            $this->newLine();
            $this->components->info($category);

            usort(
                $items,
                fn(array $a, array $b): int => strcmp($a["name"], $b["name"]),
            );

            foreach ($items as $component) {
                $installed = $files->exists(
                    $base . "/" . $component["name"] . ".blade.php",
                );

                $this->components->twoColumnDetail(
                    sprintf(
                        "%s %s",
                        $installed ? "<fg=green>●</>" : "<fg=gray>○</>",
                        $component["name"],
                    ),
                    $component["description"] ?? "",
                );
            }
        }

        $this->newLine();
        $this->line("  <fg=green>●</> installed   <fg=gray>○</> available");

        return self::SUCCESS;
    }
}
