<?php

declare(strict_types=1);

namespace Safi\LaralcnUi\Registry;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Reads the registry. The registry_url may be a remote base (raw GitHub)
 * or, for monorepo development, an absolute filesystem path to /registry.
 * This is the single source the CLI and the website share (PRD §6.1).
 */
final class RegistryClient
{
    public function __construct(
        private readonly string $registryUrl,
        private readonly Filesystem $files,
    ) {}

    public function isLocal(): bool
    {
        return !str_starts_with($this->registryUrl, "http://") &&
            !str_starts_with($this->registryUrl, "https://");
    }

    /**
     * The full catalogue.
     *
     * @return array<string, mixed>
     */
    public function index(): array
    {
        return $this->json("index.json");
    }

    /**
     * A single component's registry entry.
     *
     * @return array<string, mixed>
     */
    public function component(string $name): array
    {
        return $this->json("components/{$name}/component.json");
    }

    /**
     * A single block's registry entry.
     *
     * @return array<string, mixed>
     */
    public function block(string $name): array
    {
        return $this->json("blocks/{$name}/component.json");
    }

    /**
     * Raw contents of one of a component's source files.
     */
    public function fileContents(string $name, string $source): string
    {
        return $this->raw("components/{$name}/{$source}");
    }

    /**
     * Raw contents of one of a block's source files.
     */
    public function blockFileContents(string $name, string $source): string
    {
        return $this->raw("blocks/{$name}/{$source}");
    }

    /**
     * @return array<string, mixed>
     */
    private function json(string $relative): array
    {
        $contents = $this->raw($relative);

        $decoded = json_decode($contents, true);

        if (!is_array($decoded)) {
            throw new RuntimeException(
                "Registry file [{$relative}] is not valid JSON.",
            );
        }

        return $decoded;
    }

    private function raw(string $relative): string
    {
        if ($this->isLocal()) {
            $path = rtrim($this->registryUrl, "/") . "/" . $relative;

            if (!$this->files->exists($path)) {
                throw new RuntimeException("Registry file not found: {$path}");
            }

            return $this->files->get($path);
        }

        $url = rtrim($this->registryUrl, "/") . "/" . $relative;

        $response = Http::acceptJson()->get($url);

        if ($response->failed()) {
            throw new RuntimeException(
                "Failed to fetch [{$url}] from registry (HTTP {$response->status()}).",
            );
        }

        return $response->body();
    }
}
