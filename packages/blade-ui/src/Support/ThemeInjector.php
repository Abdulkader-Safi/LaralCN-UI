<?php

declare(strict_types=1);

namespace Safi\LaralcnUi\Support;

use Illuminate\Filesystem\Filesystem;

/**
 * Idempotently injects the LaralCN-UI theme variables into the app's
 * Tailwind v4 entry stylesheet, between sentinel markers, so `ui:init`
 * is safe to run repeatedly and never clobbers existing CSS (PRD §7.4).
 */
final class ThemeInjector
{
    public const START = "/* laralcn-ui:start, managed block, edit theme tokens here, do not remove the markers */";

    public const END = "/* laralcn-ui:end */";

    public function __construct(private readonly Filesystem $files) {}

    /**
     * @return 'created'|'updated'|'unchanged'
     */
    public function inject(string $cssPath, string $themeBlock): string
    {
        $managed = self::START . "\n" . trim($themeBlock) . "\n" . self::END;

        if (!$this->files->exists($cssPath)) {
            $this->files->ensureDirectoryExists(dirname($cssPath));
            $this->files->put($cssPath, $managed . "\n");

            return "created";
        }

        $current = $this->files->get($cssPath);

        if ($this->hasManagedBlock($current)) {
            $replaced = $this->replaceManagedBlock($current, $managed);

            if ($replaced === $current) {
                return "unchanged";
            }

            $this->files->put($cssPath, $replaced);

            return "updated";
        }

        $this->files->put($cssPath, rtrim($current) . "\n\n" . $managed . "\n");

        return "updated";
    }

    public function hasManagedBlock(string $contents): bool
    {
        return str_contains($contents, self::START) &&
            str_contains($contents, self::END);
    }

    private function replaceManagedBlock(
        string $contents,
        string $managed,
    ): string {
        $pattern =
            "/" .
            preg_quote(self::START, "/") .
            ".*?" .
            preg_quote(self::END, "/") .
            "/s";

        return (string) preg_replace(
            $pattern,
            $this->escapeReplacement($managed),
            $contents,
            1,
        );
    }

    private function escapeReplacement(string $value): string
    {
        return str_replace(["\\", '$'], ["\\\\", '\\$'], $value);
    }
}
