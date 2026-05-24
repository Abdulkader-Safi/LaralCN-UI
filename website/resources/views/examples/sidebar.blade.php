{{-- The sidebar is a full-height, fixed-position layout primitive, so it cannot
     embed directly inside the docs column. We preview the real sidebar-08 block
     in an iframe; open it standalone for the full experience. --}}
<div class="space-y-3">
    <div class="overflow-hidden rounded-lg border border-border" style="height: 520px">
        <iframe src="{{ route('blocks.sidebar-08') }}"
            class="h-full w-full" title="sidebar-08 block"
            loading="lazy"></iframe>
    </div>
    <a href="{{ route('blocks.sidebar-08') }}" target="_blank"
        rel="noopener noreferrer"
        class="inline-flex text-sm text-muted-foreground underline underline-offset-4 hover:text-foreground">
        Open the sidebar-08 block full screen &rarr;
    </a>
</div>
