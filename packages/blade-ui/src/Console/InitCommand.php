<?php

declare(strict_types=1);

namespace Safi\LaralcnUi\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Safi\LaralcnUi\Console\Concerns\InteractsWithProject;
use Safi\LaralcnUi\Support\ThemeInjector;

final class InitCommand extends Command
{
    use InteractsWithProject;

    protected $signature = "ui:init {--force : Re-publish the config file, overwriting an existing one}";

    protected $description = "One-time LaralCN-UI project setup (idempotent: safe to re-run).";

    private const TAILWIND_MERGE = "gehrisandro/tailwind-merge-laravel";

    public function handle(Filesystem $files, ThemeInjector $injector): int
    {
        $this->components->info("LaralCN-UI setup");

        // 1. Publish config (no --force => won't clobber an existing one).
        $this->callSilently(
            "vendor:publish",
            array_filter([
                "--tag" => "laralcn-ui-config",
                "--force" => $this->option("force") ?: null,
            ]),
        );
        $this->line("  <fg=green>✓</> config/laralcn-ui.php");

        // 2. Verify Tailwind v4.
        if ($this->hasTailwindV4()) {
            $this->line("  <fg=green>✓</> Tailwind CSS v4 detected");
        } else {
            $this->warn("  ! Tailwind CSS v4 not detected in package.json.");
            $this->line(
                "    LaralCN-UI targets the default `laravel new` setup (Tailwind v4, CSS-first).",
            );
        }

        // 3. Ensure components directory.
        $componentsPath = $this->componentsBasePath();
        $files->ensureDirectoryExists($componentsPath);
        $this->line(
            "  <fg=green>✓</> " . $this->relative($componentsPath) . "/",
        );

        // 4. Inject theme variables idempotently.
        $themeStub = $files->get(__DIR__ . "/../../resources/stubs/theme.css");
        $status = $injector->inject($this->cssPath(), $themeStub);
        $this->line(
            sprintf(
                "  <fg=green>✓</> theme variables %s in %s",
                $status,
                $this->relative($this->cssPath()),
            ),
        );

        // 5. tailwind-merge dependency (required by every component).
        if ($this->composerHas(self::TAILWIND_MERGE)) {
            $this->line(
                "  <fg=green>✓</> " . self::TAILWIND_MERGE . " installed",
            );
        } else {
            $this->newLine();
            $this->warn(
                "  Components need " .
                    self::TAILWIND_MERGE .
                    " so class overrides work.",
            );
            $this->line(
                "  Run:  <fg=cyan>composer require " .
                    self::TAILWIND_MERGE .
                    "</>",
            );
        }

        // 6. Alpine guidance (never auto-installed).
        if (
            config("laralcn-ui.js") === "alpine" &&
            !$this->npmHas("alpinejs")
        ) {
            $this->newLine();
            $this->line(
                "  Interactive components (dialog, dropdown, ...) need Alpine.js.",
            );
            $this->line(
                "  When you add one:  <fg=cyan>npm install alpinejs</>",
            );
        }

        $this->newLine();
        $this->components->info(
            "Done. Add a component with: php artisan ui:add button",
        );

        return self::SUCCESS;
    }

    private function hasTailwindV4(): bool
    {
        $pkg = $this->packageJson();

        $version =
            $pkg["devDependencies"]["tailwindcss"] ??
            ($pkg["dependencies"]["tailwindcss"] ?? null);

        if ($this->npmHas("@tailwindcss/vite")) {
            return true;
        }

        return is_string($version) && str_contains($version, "4");
    }

    private function relative(string $absolute): string
    {
        return ltrim(str_replace(base_path(), "", $absolute), "/");
    }
}
