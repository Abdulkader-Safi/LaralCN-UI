<?php

declare(strict_types=1);

namespace Safi\LaralcnUi\Console\Concerns;

use Illuminate\Filesystem\Filesystem;
use Safi\LaralcnUi\Registry\RegistryClient;

/**
 * Shared config/registry/path access for the ui:* commands.
 */
trait InteractsWithProject
{
    protected function registry(): RegistryClient
    {
        return new RegistryClient(
            (string) config("laralcn-ui.registry_url"),
            app(Filesystem::class),
        );
    }

    protected function componentsBasePath(): string
    {
        return base_path((string) config("laralcn-ui.components_path"));
    }

    protected function cssPath(): string
    {
        return base_path((string) config("laralcn-ui.css_path"));
    }

    /**
     * @return array<string, mixed>
     */
    protected function composerJson(): array
    {
        $files = app(Filesystem::class);
        $path = base_path("composer.json");

        if (!$files->exists($path)) {
            return [];
        }

        return (array) json_decode($files->get($path), true);
    }

    /**
     * @return array<string, mixed>
     */
    protected function packageJson(): array
    {
        $files = app(Filesystem::class);
        $path = base_path("package.json");

        if (!$files->exists($path)) {
            return [];
        }

        return (array) json_decode($files->get($path), true);
    }

    protected function composerHas(string $package): bool
    {
        $composer = $this->composerJson();

        return isset($composer["require"][$package]) ||
            isset($composer["require-dev"][$package]);
    }

    protected function npmHas(string $package): bool
    {
        $pkg = $this->packageJson();

        return isset($pkg["dependencies"][$package]) ||
            isset($pkg["devDependencies"][$package]);
    }
}
