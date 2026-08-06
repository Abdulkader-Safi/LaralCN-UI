{{-- open sets the starting state; after that a cookie and Ctrl/Cmd-B win --}}
<x-ui.sidebar.provider :open="false">
    <x-ui.sidebar collapsible="offcanvas">
        <x-ui.sidebar.header>
            <x-ui.sidebar.menu>
                <x-ui.sidebar.menu-item>
                    <x-ui.sidebar.menu-button size="lg" href="/">Acme</x-ui.sidebar.menu-button>
                </x-ui.sidebar.menu-item>
            </x-ui.sidebar.menu>
        </x-ui.sidebar.header>

        <x-ui.sidebar.content>
            <x-ui.sidebar.group>
                <x-ui.sidebar.group-label>Platform</x-ui.sidebar.group-label>
                <x-ui.sidebar.menu>
                    @foreach ($links as $link)
                        <x-ui.sidebar.menu-item>
                            <x-ui.sidebar.menu-button :href="$link['href']" :tooltip="$link['label']"
                                :is-active="request()->is(ltrim($link['href'], '/'))">
                                {{ $link['label'] }}
                            </x-ui.sidebar.menu-button>
                        </x-ui.sidebar.menu-item>
                    @endforeach
                </x-ui.sidebar.menu>
            </x-ui.sidebar.group>
        </x-ui.sidebar.content>
    </x-ui.sidebar>

    <x-ui.sidebar.inset>
        <x-ui.sidebar.trigger />
        {{ $slot }}
    </x-ui.sidebar.inset>
</x-ui.sidebar.provider>
