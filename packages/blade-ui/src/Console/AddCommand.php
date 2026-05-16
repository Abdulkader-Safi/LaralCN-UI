<?php

declare(strict_types=1);

namespace Safi\LaralcnUi\Console;

use Illuminate\Console\Command;
use Safi\LaralcnUi\Console\Concerns\InteractsWithProject;
use Safi\LaralcnUi\Registry\DependencyResolver;
use Safi\LaralcnUi\Registry\FileInstaller;
use Throwable;

final class AddCommand extends Command
{
    use InteractsWithProject;

    protected $signature = 'ui:add
        {component* : One or more component names}
        {--overwrite : Overwrite existing files without prompting}';

    protected $description = "Add components (and their dependencies) into your project.";

    public function handle(FileInstaller $installer): int
    {
        $registry = $this->registry();
        $resolver = new DependencyResolver($registry);

        /** @var array<int, string> $requested */
        $requested = $this->argument("component");

        try {
            $resolved = $resolver->resolve($requested);
        } catch (Throwable $e) {
            $this->components->error($e->getMessage());

            return self::FAILURE;
        }

        $base = $this->componentsBasePath();

        $pulledIn = array_values(
            array_diff(
                array_column($resolved["components"], "name"),
                $requested,
            ),
        );

        if ($pulledIn !== []) {
            $this->components->info(
                "Including required components: " . implode(", ", $pulledIn),
            );
        }

        foreach ($resolved["components"] as $entry) {
            $name = $entry["name"];

            try {
                $results = $installer->install(
                    $name,
                    $entry["files"],
                    $registry,
                    $base,
                    fn(
                        string $target,
                        string $existing,
                        string $incoming,
                    ): string => $this->resolveConflict(
                        $target,
                        $existing,
                        $incoming,
                    ),
                );
            } catch (Throwable $e) {
                $this->components->error("[{$name}] {$e->getMessage()}");

                return self::FAILURE;
            }

            foreach ($results as $result) {
                $this->components->twoColumnDetail(
                    $this->relative($result["path"]),
                    $result["status"],
                );
            }
        }

        $this->reportManualDependencies($resolved["composer"], $resolved["js"]);

        return self::SUCCESS;
    }

    private function resolveConflict(
        string $target,
        string $existing,
        string $incoming,
    ): string {
        if ($this->option("overwrite")) {
            return "overwrite";
        }

        $this->newLine();
        $this->warn(
            "File already exists and differs: " . $this->relative($target),
        );

        $choice = $this->choice(
            "What would you like to do?",
            ["skip", "overwrite", "diff"],
            "skip",
        );

        if ($choice === "diff") {
            $this->renderDiff($existing, $incoming);

            return $this->confirm("Overwrite this file?", false)
                ? "overwrite"
                : "skip";
        }

        return $choice;
    }

    private function renderDiff(string $existing, string $incoming): void
    {
        $a = explode("\n", $existing);
        $b = explode("\n", $incoming);
        $max = max(count($a), count($b));

        for ($i = 0; $i < $max; $i++) {
            $left = $a[$i] ?? null;
            $right = $b[$i] ?? null;

            if ($left === $right) {
                $this->line("  " . $left);

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

    /**
     * @param  array<int, string>  $composer
     * @param  array<int, string>  $js
     */
    private function reportManualDependencies(array $composer, array $js): void
    {
        $missingComposer = array_values(
            array_filter(
                $composer,
                fn(string $p): bool => !$this->composerHas($p),
            ),
        );
        $missingJs = array_values(
            array_filter($js, fn(string $p): bool => !$this->npmHas($p)),
        );

        if ($missingComposer === [] && $missingJs === []) {
            return;
        }

        $this->newLine();
        $this->components->warn("You still need to install:");

        if ($missingComposer !== []) {
            $this->line(
                "  <fg=cyan>composer require " .
                    implode(" ", $missingComposer) .
                    "</>",
            );
        }

        if ($missingJs !== []) {
            $this->line(
                "  <fg=cyan>npm install " . implode(" ", $missingJs) . "</>",
            );
        }
    }

    private function relative(string $absolute): string
    {
        return ltrim(str_replace(base_path(), "", $absolute), "/");
    }
}
