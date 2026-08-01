@props([
    'code' => '',
    'language' => 'blade',
])

@php
    $code = trim($code);

    // Shiki shells out to Node, so each block costs ~150ms. The source only
    // changes when the registry does, so cache the rendered HTML on its hash.
    //
    // Node is not guaranteed to be on PHP-FPM's PATH (an nvm install is not),
    // and a missing binary must never take a page down: on failure we fall
    // back to plain, unhighlighted code and retry on the next request rather
    // than caching the failure forever.
    $cacheKey = 'shiki:' . $language . ':' . md5($code);
    $highlighted = \Illuminate\Support\Facades\Cache::get($cacheKey);

    if ($highlighted === null) {
        try {
            $highlighted = \Spatie\ShikiPhp\Shiki::highlight(
                code: $code,
                language: $language,
                theme: 'github-dark',
            );

            \Illuminate\Support\Facades\Cache::forever($cacheKey, $highlighted);
        } catch (\Throwable) {
            // Deliberately silent, not even report(): if storage/logs is not
            // writable the log write throws too, turning a cosmetic problem
            // back into a 500. Highlighting is decoration; the page is not.
            $highlighted = null;
        }
    }
@endphp

<div class="relative">
    <button type="button" data-copy="{{ $code }}"
        class="group absolute right-3 top-3 z-10 rounded-md border border-border bg-background px-2.5 py-1 text-xs text-muted-foreground hover:bg-accent hover:text-accent-foreground">
        <span class="group-data-[copied]:hidden">Copy</span>
        <span class="hidden group-data-[copied]:inline">Copied!</span>
    </button>
    <div
        {{ $attributes->merge(['class' => 'overflow-hidden rounded-lg border border-border']) }}>
        @if ($highlighted)
            {!! $highlighted !!}
        @else
            <pre class="shiki"
                style="background-color:#24292e;color:#e1e4e8"><code>{{ $code }}</code></pre>
        @endif
    </div>
</div>
