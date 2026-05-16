<?php

declare(strict_types=1);

namespace Safi\LaralcnUi\Tests;

use Illuminate\Filesystem\Filesystem;
use Orchestra\Testbench\TestCase as Orchestra;
use Safi\LaralcnUi\LaralcnUiServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        new Filesystem()->deleteDirectory($this->sandboxPath());
    }

    protected function tearDown(): void
    {
        new Filesystem()->deleteDirectory($this->sandboxPath());

        parent::tearDown();
    }

    protected function getPackageProviders($app): array
    {
        return [
            \TailwindMerge\Laravel\TailwindMergeServiceProvider::class,
            LaralcnUiServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app["config"]->set("laralcn-ui.registry_url", $this->registryPath());
        $app["config"]->set(
            "laralcn-ui.components_path",
            "laralcn-sandbox/components",
        );
        $app["config"]->set("laralcn-ui.css_path", "laralcn-sandbox/app.css");
    }

    protected function registryPath(): string
    {
        return dirname(__DIR__) . "/registry";
    }

    protected function sandboxPath(string $append = ""): string
    {
        return base_path(
            "laralcn-sandbox" .
                ($append !== "" ? "/" . ltrim($append, "/") : ""),
        );
    }
}
