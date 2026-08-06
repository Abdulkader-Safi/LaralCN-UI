<x-ui.scroll-area class="h-48 w-full max-w-xs rounded-md border p-4">
    <h4 class="mb-3 text-sm font-medium leading-none">Releases</h4>
    @foreach (range(1, 20) as $i)
        <div class="border-b py-2 text-sm last:border-b-0">
            v0.{{ $i }}.0
        </div>
    @endforeach
</x-ui.scroll-area>
