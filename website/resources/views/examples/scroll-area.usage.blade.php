<x-ui.scroll-area class="h-48 w-full max-w-xs rounded-md border p-4">
    {{-- The height comes from `class`; without one there is nothing to scroll. --}}
    @foreach ($releases as $release)
        <div class="border-b py-2 text-sm last:border-b-0">{{ $release }}</div>
    @endforeach
</x-ui.scroll-area>
