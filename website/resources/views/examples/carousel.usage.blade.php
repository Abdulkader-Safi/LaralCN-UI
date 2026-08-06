<x-ui.carousel class="w-full max-w-xs">
    @foreach ($slides as $slide)
        {{-- basis-full by default; use class="basis-1/2" for a multi-up row. --}}
        <x-ui.carousel.item>
            <x-ui.card>{{ $slide }}</x-ui.card>
        </x-ui.carousel.item>
    @endforeach
</x-ui.carousel>
