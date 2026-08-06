<x-ui.carousel class="w-full max-w-xs">
    @foreach (range(1, 5) as $i)
        <x-ui.carousel.item>
            <x-ui.card class="flex aspect-square items-center justify-center">
                <span class="text-4xl font-semibold">{{ $i }}</span>
            </x-ui.card>
        </x-ui.carousel.item>
    @endforeach
</x-ui.carousel>
