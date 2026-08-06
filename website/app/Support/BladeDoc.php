<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Pulls the documentation that already lives inside a component's Blade source:
 * its `@props([...])` block, and the usage example in its leading comment.
 *
 * Deriving both from the source is the only way they stay honest. A hand-written
 * props table on the docs site goes stale the first time a prop is renamed.
 */
final class BladeDoc
{
    /** The `@props([...])` declaration verbatim, or null when there is none. */
    public static function props(string $code): ?string
    {
        $start = strpos($code, "@props(");

        if ($start === false) {
            return null;
        }

        // ponytail: brace counting, not a PHP parser. A default value containing
        // an unbalanced paren inside a string returns null and the docs page
        // simply omits the section, which is the safe way to be wrong.
        $depth = 0;
        $length = strlen($code);

        for ($i = $start + strlen("@props"); $i < $length; $i++) {
            if ($code[$i] === "(") {
                $depth++;
            } elseif ($code[$i] === ")") {
                $depth--;

                if ($depth === 0) {
                    return substr($code, $start, $i - $start + 1);
                }
            }
        }

        return null;
    }

    /** The `<x-ui…/>` example from the leading Blade comment, or null. */
    public static function usage(string $code): ?string
    {
        $comment = self::leadingComment($code);

        if ($comment === null) {
            return null;
        }

        $start = strpos($comment, "<x-ui");

        if ($start === false) {
            return null;
        }

        $end = strpos($comment, "/>", $start);

        if ($end === false) {
            return null;
        }

        return self::dedent(substr($comment, $start, $end - $start + 2));
    }

    /** The prose in the leading comment with the example stripped out, or null. */
    public static function notes(string $code): ?string
    {
        $comment = self::leadingComment($code);

        if ($comment === null) {
            return null;
        }

        $lines = [];
        $inExample = false;

        foreach (explode("\n", $comment) as $line) {
            if (str_contains($line, "<x-ui")) {
                $inExample = true;
            }

            if (!$inExample) {
                $lines[] = trim($line);
            }

            if ($inExample && str_contains($line, "/>")) {
                $inExample = false;
            }
        }

        $notes = trim(implode("\n", $lines));

        return $notes === "" ? null : $notes;
    }

    private static function leadingComment(string $code): ?string
    {
        $code = ltrim($code);

        if (!str_starts_with($code, "{{--")) {
            return null;
        }

        $end = strpos($code, "--}}");

        if ($end === false) {
            return null;
        }

        return substr($code, 4, $end - 4);
    }

    private static function dedent(string $code): string
    {
        $lines = explode("\n", $code);
        $indents = [];

        foreach (array_slice($lines, 1) as $line) {
            if (trim($line) !== "") {
                $indents[] = strlen($line) - strlen(ltrim($line));
            }
        }

        $shift = $indents === [] ? 0 : min($indents);

        return implode(
            "\n",
            array_map(
                static fn(string $line, int $i): string => $i === 0
                    ? $line
                    : substr($line, $shift),
                $lines,
                array_keys($lines),
            ),
        );
    }
}
