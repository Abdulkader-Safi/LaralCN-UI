<?php

declare(strict_types=1);

namespace Safi\LaralcnUi\Console;

use Illuminate\Console\Command;
use Safi\LaralcnUi\Console\Concerns\InteractsWithProject;
use Safi\LaralcnUi\Registry\DependencyResolver;
use Safi\LaralcnUi\Registry\FileInstaller;
use Throwable;

final class AddBlockCommand extends Command
{
    use InteractsWithProject;

    protected $signature = 'ui:add-block
        {block* : One or more block names}
        {--overwrite : Overwrite existing files without prompting}';

    protected $description = "Add a block (and every component it depends on) into your project.";

    public function handle(FileInstaller $installer): int
    {
        $registry = $this->registry();
        $resolver = new DependencyResolver($registry);
        $base = $this->componentsBasePath();

        /** @var array<int, string> $requested */
        $requested = $this->argument("block");

        $blocks = [];
        $componentRoots = [];
        $blockJs = [];
        $blockComposer = [];

        foreach ($requested as $name) {
            try {
                $entry = $registry->block($name);
            } catch (Throwable $e) {
                $this->components->error($e->getMessage());

                return self::FAILURE;
            }

            $blocks[] = $entry;

            foreach ($entry["dependencies"]["components"] ?? [] as $dep) {
                $componentRoots[] = $dep;
            }

            foreach ($entry["dependencies"]["js"] ?? [] as $package) {
                $blockJs[$package] = true;
            }

            foreach ($entry["dependencies"]["composer"] ?? [] as $package) {
                $blockComposer[$package] = true;
            }
        }

        try {
            $resolved = $resolver->resolve(
                array_values(array_unique($componentRoots)),
            );
        } catch (Throwable $e) {
            $this->components->error($e->getMessage());

            return self::FAILURE;
        }

        $componentNames = array_column($resolved["components"], "name");

        if ($componentNames !== []) {
            $this->components->info(
                "Including required components: " .
                    implode(", ", $componentNames),
            );
        }

        foreach ($resolved["components"] as $entry) {
            $name = $entry["name"];

            try {
                $results = $installer->install(
                    $entry["files"],
                    fn(string $source): string => $registry->fileContents(
                        $name,
                        $source,
                    ),
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

        foreach ($blocks as $entry) {
            $name = $entry["name"];

            try {
                $results = $installer->install(
                    $entry["files"],
                    fn(string $source): string => $registry->blockFileContents(
                        $name,
                        $source,
                    ),
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
                $this->components->error("[block:{$name}] {$e->getMessage()}");

                return self::FAILURE;
            }

            foreach ($results as $result) {
                $this->components->twoColumnDetail(
                    $this->relative($result["path"]),
                    $result["status"],
                );
            }
        }

        $composer = array_values(
            array_unique(
                array_merge($resolved["composer"], array_keys($blockComposer)),
            ),
        );
        $js = array_values(
            array_unique(array_merge($resolved["js"], array_keys($blockJs))),
        );

        $this->reportManualDependencies($composer, $js);

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
