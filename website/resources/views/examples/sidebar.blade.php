{{-- The sidebar is a full-height, fixed-position layout primitive, so it cannot
     embed directly inside the docs column. We preview the real sidebar-01 block
     in an iframe; open it standalone for the full experience. --}}
<div class="space-y-3">
    <div class="overflow-hidden rounded-lg border border-border" style="height: 520px">
        <iframe src="{{ route('blocks.preview', 'sidebar-01') }}"
            class="h-full w-full" title="sidebar-01 block"
            loading="lazy"></iframe>
    </div>
    <a href="{{ route('blocks.preview', 'sidebar-01') }}" target="_blank"
        rel="noopener noreferrer"
        class="inline-flex text-sm text-muted-foreground underline underline-offset-4 hover:text-foreground">
        Open the sidebar-01 block full screen &rarr;
    </a>
</div>
