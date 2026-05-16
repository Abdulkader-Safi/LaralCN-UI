<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Collection;
use RuntimeException;

/**
 * Reads the LaralCN-UI registry directly off disk (monorepo). This is the
 * exact same source the CLI installs from, so the website's previews and
 * copyable source are guaranteed in parity with `php artisan ui:add`.
 */
final class Registry
{
    private string $base;

    public function __construct()
    {
        $this->base = rtrim((string) config('laralcn-ui.registry_url'), '/');

        if (! is_dir($this->base)) {
            throw new RuntimeException("Registry not found at {$this->base}");
        }
    }

    /** @return Collection<int, array<string, mixed>> */
    public function all(): Collection
    {
        $index = json_decode((string) file_get_contents($this->base.'/index.json'), true);

        return collect($index['components'] ?? [])
            ->sortBy('name')
            ->values();
    }

    /** @return Collection<string, Collection<int, array<string, mixed>>> */
    public function byCategory(): Collection
    {
        return $this->all()->groupBy('category');
    }

    /** @return array<string, mixed>|null */
    public function find(string $name): ?array
    {
        $path = $this->base."/components/{$name}/component.json";

        if (! is_file($path)) {
            return null;
        }

        return json_decode((string) file_get_contents($path), true);
    }

    public function source(string $name, string $sourcePath): string
    {
        $path = $this->base."/components/{$name}/{$sourcePath}";

        return is_file($path) ? (string) file_get_contents($path) : '';
    }

    public function command(string $name): string
    {
        return "php artisan ui:add {$name}";
    }

    public function themeCss(): string
    {
        $stub = dirname($this->base).'/packages/blade-ui/resources/stubs/theme.css';

        return is_file($stub) ? (string) file_get_contents($stub) : '';
    }
}
