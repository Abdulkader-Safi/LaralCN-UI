@php
    $columns = [
        'Column One' => ['Link One', 'Link Two', 'Link Three', 'Link Four', 'Link Five'],
        'Column Two' => ['Link Six', 'Link Seven', 'Link Eight', 'Link Nine', 'Link Ten'],
        'Column Three' => ['Link Eleven', 'Link Twelve', 'Link Thirteen', 'Link Fourteen', 'Link Fifteen'],
        'Column Four' => ['Link Sixteen', 'Link Seventeen', 'Link Eighteen', 'Link Nineteen', 'Link Twenty'],
        'Column Five' => [
            'Link Twenty One',
            'Link Twenty Two',
            'Link Twenty Three',
            'Link Twenty Four',
            'Link Twenty Five',
        ],
        'Column Six' => [
            'Link Twenty Six',
            'Link Twenty Seven',
            'Link Twenty Eight',
            'Link Twenty Nine',
            'Link Thirty',
        ],
    ];
    $team = ['Team member one', 'Team member two', 'Team member three', 'Team member four', 'Team member five'];

    $socials = [
        [
            'label' => 'Facebook',
            'svg' =>
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>',
        ],
        [
            'label' => 'Instagram',
            'svg' =>
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5" aria-hidden="true"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>',
        ],
        [
            'label' => 'X',
            'svg' =>
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4" aria-hidden="true"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg>',
        ],
        [
            'label' => 'LinkedIn',
            'svg' =>
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>',
        ],
        [
            'label' => 'Youtube',
            'svg' =>
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5" aria-hidden="true"><path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/><path d="m10 15 5-3-5-3z"/></svg>',
        ],
    ];
@endphp

<footer class="w-full border-t border-border bg-background">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8 lg:py-20">
        {{-- Heading + actions --}}
        <div
            class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
            <h2
                class="max-w-2xl text-3xl font-bold tracking-tight text-foreground md:text-4xl lg:text-5xl">
                Medium length footer heading goes here
            </h2>
            <div class="flex flex-wrap items-center gap-3">
                <x-ui.button>Button</x-ui.button>
                <x-ui.button variant="outline">Button</x-ui.button>
            </div>
        </div>

        <p class="mt-6 max-w-2xl text-sm text-muted-foreground">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse
            varius enim in eros elementum tristique.
        </p>

        {{-- Link columns --}}
        <div
            class="mt-12 grid grid-cols-2 gap-8 border-t border-border pt-12 md:grid-cols-3 lg:grid-cols-6">
            @foreach ($columns as $heading => $links)
                <div class="flex flex-col gap-3">
                    <h3 class="text-sm font-semibold text-foreground">
                        {{ $heading }}</h3>
                    <ul class="flex flex-col gap-2">
                        @foreach ($links as $link)
                            <li>
                                <a href="#"
                                    class="text-sm text-muted-foreground transition-colors hover:text-foreground">{{ $link }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        {{-- Logo + team --}}
        <div
            class="mt-12 flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <a href="#"
                class="flex items-center gap-2 font-semibold text-foreground">
                <span
                    class="flex size-8 items-center justify-center rounded-md bg-primary text-primary-foreground">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="size-5" aria-hidden="true">
                        <path d="M12 2 2 7l10 5 10-5-10-5Z" />
                        <path d="m2 17 10 5 10-5" />
                        <path d="m2 12 10 5 10-5" />
                    </svg>
                </span>
                <span class="text-lg">LaralCN</span>
            </a>

            {{-- Swap the empty avatars for real ones: <x-ui.avatar src="..." alt="..." /> --}}
            <div class="flex -space-x-3">
                @foreach ($team as $member)
                    <x-ui.avatar class="size-12 ring-2 ring-background"
                        :alt="$member" />
                @endforeach
            </div>
        </div>

        <div
            class="mt-8 flex flex-col-reverse gap-4 border-t border-border pt-6 text-sm text-muted-foreground md:flex-row md:items-center md:justify-between">
            <p>&copy; {{ date('Y') }} LaralCN. All rights reserved.</p>
            <ul class="flex items-center gap-4">
                @foreach ($socials as $social)
                    <li>
                        <a href="#" aria-label="{{ $social['label'] }}"
                            class="flex size-6 items-center justify-center text-foreground transition-opacity hover:opacity-70">
                            {!! $social['svg'] !!}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</footer>
