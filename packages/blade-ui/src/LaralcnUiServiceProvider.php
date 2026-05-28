<?php

declare(strict_types=1);

namespace Safi\LaralcnUi;

use Illuminate\Support\ServiceProvider;
use Safi\LaralcnUi\Console\AddBlockCommand;
use Safi\LaralcnUi\Console\AddCommand;
use Safi\LaralcnUi\Console\DiffCommand;
use Safi\LaralcnUi\Console\InitCommand;
use Safi\LaralcnUi\Console\ListCommand;

final class LaralcnUiServiceProvider extends ServiceProvider
{
    private const CONFIG_PATH = __DIR__ . "/../config/laralcn-ui.php";

    public function register(): void
    {
        $this->mergeConfigFrom(self::CONFIG_PATH, "laralcn-ui");
    }

    public function boot(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->publishes(
            [
                self::CONFIG_PATH => $this->app->configPath("laralcn-ui.php"),
            ],
            "laralcn-ui-config",
        );

        $this->commands([
            InitCommand::class,
            AddCommand::class,
            AddBlockCommand::class,
            ListCommand::class,
            DiffCommand::class,
        ]);
    }
}
