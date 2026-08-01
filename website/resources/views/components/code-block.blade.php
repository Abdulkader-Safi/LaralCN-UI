@props([
    'code' => '',
    'language' => 'blade',
])

@php
    $code = trim($code);

    // Shiki shells out to Node, so each block costs ~150ms. The source only
    // changes when the registry does, so cache the rendered HTML on its hash.
    $highlighted = \Illuminate\Support\Facades\Cache::rememberForever(
        'shiki:' . $language . ':' . md5($code),
        fn() => \Spatie\ShikiPhp\Shiki::highlight(
            code: $code,
            language: $language,
            theme: 'github-dark',
        ),
    );
@endphp

<div class="relative">
    <button type="button" data-copy="{{ $code }}"
        class="group absolute right-3 top-3 z-10 rounded-md border border-border bg-background px-2.5 py-1 text-xs text-muted-foreground hover:bg-accent hover:text-accent-foreground">
        <span class="group-data-[copied]:hidden">Copy</span>
        <span class="hidden group-data-[copied]:inline">Copied!</span>
    </button>
    <div
        {{ $attributes->merge(['class' => 'overflow-hidden rounded-lg border border-border']) }}>
        {!! $highlighted !!}
    </div>
</div>
