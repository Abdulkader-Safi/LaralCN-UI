{{-- Hand-built --}}
<x-ui.pagination>
    <x-ui.pagination.content>
        <x-ui.pagination.item>
            <x-ui.pagination.previous href="?page=1" />
        </x-ui.pagination.item>
        <x-ui.pagination.item>
            <x-ui.pagination.link href="?page=2" :is-active="true">2</x-ui.pagination.link>
        </x-ui.pagination.item>
        <x-ui.pagination.item>
            <x-ui.pagination.ellipsis />
        </x-ui.pagination.item>
        <x-ui.pagination.item>
            <x-ui.pagination.next href="?page=3" />
        </x-ui.pagination.item>
    </x-ui.pagination.content>
</x-ui.pagination>

{{-- Driven by a Laravel paginator --}}
<x-ui.pagination>
    <x-ui.pagination.content>
        @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
            <x-ui.pagination.item>
                <x-ui.pagination.link :href="$url" :is-active="$page === $posts->currentPage()">
                    {{ $page }}
                </x-ui.pagination.link>
            </x-ui.pagination.item>
        @endforeach
    </x-ui.pagination.content>
</x-ui.pagination>
