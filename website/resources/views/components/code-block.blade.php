@props([
    'code' => '',
    'language' => 'xml',
])

<div class="relative">
    <button type="button" data-copy="{{ $code }}"
        class="group absolute right-3 top-3 z-10 rounded-md border border-border bg-background px-2.5 py-1 text-xs text-muted-foreground hover:bg-accent hover:text-accent-foreground">
        <span class="group-data-[copied]:hidden">Copy</span>
        <span class="hidden group-data-[copied]:inline">Copied!</span>
    </button>
    <pre
        {{ $attributes->merge(['class' => 'overflow-x-auto overflow-hidden rounded-lg border border-border text-xs leading-relaxed']) }}><code class="language-{{ $language }} rounded-lg">{{ trim($code) }}</code></pre>
</div>
