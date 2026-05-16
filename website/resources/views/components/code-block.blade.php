@props([
    'code' => '',
    'language' => 'xml',
])

<div class="relative" x-data="{ copied: false, source: @js($code) }">
    <button type="button"
        class="absolute right-3 top-3 z-10 rounded-md border border-border bg-background px-2.5 py-1 text-xs text-muted-foreground hover:bg-accent hover:text-accent-foreground"
        @click="navigator.clipboard.writeText(source); copied = true; setTimeout(() => copied = false, 1500)">
        <span x-show="!copied">Copy</span>
        <span x-show="copied" x-cloak>Copied!</span>
    </button>
    <pre
        {{ $attributes->merge(['class' => 'overflow-x-auto overflow-hidden rounded-lg border border-border text-xs leading-relaxed']) }}><code class="language-{{ $language }} rounded-lg">{{ trim($code) }}</code></pre>
</div>
