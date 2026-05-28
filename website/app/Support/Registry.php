<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Reads the LaralCN-UI registry — the exact same source the CLI installs
 * from, so the website's previews and copyable source stay in parity with
 * `php artisan ui:add`.
 *
 * `registry_url` may be either an absolute filesystem path (monorepo dev,
 * where /registry sits next to the app) or an http(s) base such as the
 * published raw GitHub registry (standalone production deploys, where only
 * the website is shipped). Remote reads are cached briefly to avoid hitting
 * GitHub on every request.
 */
final class Registry
{
    private string $base;

    private bool $remote;

    /** @var array<string, mixed>|null */
    private ?array $index = null;

    public function __construct()
    {
        $this->base = rtrim((string) config("laralcn-ui.registry_url"), "/");
        $this->remote =
            str_starts_with($this->base, "http://") ||
            str_starts_with($this->base, "https://");

        if (!$this->remote && !is_dir($this->base)) {
            throw new RuntimeException("Registry not found at {$this->base}");
        }
    }

    /** @return Collection<int, array<string, mixed>> */
    public function all(): Collection
    {
        return collect($this->index()["components"] ?? [])
            ->sortBy("name")
            ->values();
    }

    /** @return Collection<string, Collection<int, array<string, mixed>>> */
    public function byCategory(): Collection
    {
        return $this->all()->groupBy("category");
    }

    /** @return Collection<int, array<string, mixed>> */
    public function blocks(): Collection
    {
        return collect($this->index()["blocks"] ?? [])
            ->sortBy("name")
            ->values();
    }

    /** @return Collection<string, Collection<int, array<string, mixed>>> */
    public function blocksByCategory(): Collection
    {
        return $this->blocks()->groupBy("category");
    }

    /** @return array<string, mixed>|null */
    public function find(string $name): ?array
    {
        $contents = $this->get("components/{$name}/component.json");

        if ($contents === null) {
            return null;
        }

        $decoded = json_decode($contents, true);

        return is_array($decoded) ? $decoded : null;
    }

    /** @return array<string, mixed>|null */
    public function findBlock(string $name): ?array
    {
        $contents = $this->get("blocks/{$name}/component.json");

        if ($contents === null) {
            return null;
        }

        $decoded = json_decode($contents, true);

        return is_array($decoded) ? $decoded : null;
    }

    public function source(string $name, string $sourcePath): string
    {
        return (string) $this->get("components/{$name}/{$sourcePath}");
    }

    public function blockSource(string $name, string $sourcePath): string
    {
        return (string) $this->get("blocks/{$name}/{$sourcePath}");
    }

    public function command(string $name): string
    {
        return "php artisan ui:add {$name}";
    }

    public function blockCommand(string $name): string
    {
        return "php artisan ui:add-block {$name}";
    }

    /** @return array<string, mixed> */
    private function index(): array
    {
        $this->index ??=
            json_decode((string) $this->get("index.json"), true) ?: [];

        return $this->index;
    }

    public function themeCss(): string
    {
        // The theme stub lives next to /registry, not inside it.
        $root = $this->remote
            ? preg_replace('#/registry$#', "", $this->base)
            : dirname($this->base);

        return (string) $this->fetch(
            $root . "/packages/blade-ui/resources/stubs/theme.css",
        );
    }

    /**
     * Read one registry file (relative to the registry base), or null if it
     * does not exist.
     */
    private function get(string $relative): ?string
    {
        return $this->fetch($this->base . "/" . ltrim($relative, "/"));
    }

    private function fetch(string $location): ?string
    {
        if (!$this->remote) {
            return is_file($location)
                ? (string) file_get_contents($location)
                : null;
        }

        return Cache::remember(
            "laralcn-registry:" . sha1($location),
            now()->addMinutes(10),
            static function () use ($location): ?string {
                $response = Http::timeout(10)->get($location);

                return $response->successful() ? $response->body() : null;
            },
        );
    }
}
