<x-ui.scroll-area class="h-48 w-full max-w-xs rounded-md border p-4">
    {{-- The height comes from `class`; without one there is nothing to scroll. --}}
    @foreach ($releases as $release)
        <div class="border-b py-2 text-sm last:border-b-0">{{ $release }}</div>
    @endforeach
</x-ui.scroll-area>

{{-- horizontal scrolls sideways instead; give it a width, not a height --}}
<x-ui.scroll-area orientation="horizontal" class="w-full max-w-xs rounded-md border p-4">
    <div class="flex gap-4">
        @foreach ($covers as $cover)
            <img src="{{ $cover }}" alt="" class="size-32 shrink-0 rounded-md" />
        @endforeach
    </div>
</x-ui.scroll-area>
