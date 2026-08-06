@php
    $columnOne = ['Link One', 'Link Two', 'Link Three', 'Link Four', 'Link Five'];
    $columnTwo = ['Link Six', 'Link Seven', 'Link Eight', 'Link Nine', 'Link Ten'];
    $legal = ['Privacy Policy', 'Terms of Service', 'Cookies Settings'];

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

<footer class="w-full bg-background">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8 lg:py-20">
        {{-- Bordered card --}}
        <div class="rounded-lg border border-border p-6 lg:p-10">
            <div class="grid grid-cols-1 gap-10 lg:grid-cols-2 lg:gap-16">
                {{-- Pitch --}}
                <div class="flex flex-col gap-6">
                    <a href="#"
                        class="flex items-center gap-2 self-start font-semibold text-foreground">
                        <span
                            class="flex size-8 items-center justify-center rounded-md bg-primary text-primary-foreground">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="size-5" aria-hidden="true">
                                <path d="M12 2 2 7l10 5 10-5-10-5Z" />
                                <path d="m2 17 10 5 10-5" />
                                <path d="m2 12 10 5 10-5" />
                            </svg>
                        </span>
                        <span class="text-lg">LaralCN</span>
                    </a>

                    <h2
                        class="text-3xl font-bold tracking-tight text-foreground md:text-4xl lg:text-5xl">
                        Medium length footer heading goes here
                    </h2>

                    <p class="text-sm text-muted-foreground">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Suspendisse varius enim in eros elementum tristique.
                    </p>

                    <div class="flex flex-wrap items-center gap-3">
                        <x-ui.button>Button</x-ui.button>
                        <x-ui.button variant="outline">Button</x-ui.button>
                    </div>
                </div>

                {{-- Links + socials --}}
                <div
                    class="flex flex-col justify-between gap-10 lg:items-end lg:text-right">
                    <div class="grid grid-cols-2 gap-8">
                        <ul class="flex flex-col gap-2">
                            @foreach ($columnOne as $link)
                                <li>
                                    <a href="#"
                                        class="text-sm text-muted-foreground transition-colors hover:text-foreground">{{ $link }}</a>
                                </li>
                            @endforeach
                        </ul>
                        <ul class="flex flex-col gap-2">
                            @foreach ($columnTwo as $link)
                                <li>
                                    <a href="#"
                                        class="text-sm text-muted-foreground transition-colors hover:text-foreground">{{ $link }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

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
        </div>

        <div
            class="mt-6 flex flex-col-reverse gap-4 text-sm text-muted-foreground md:flex-row md:items-center md:justify-between">
            <p>&copy; {{ date('Y') }} LaralCN. All rights reserved.</p>
            <ul class="flex flex-col gap-3 md:flex-row md:gap-6">
                @foreach ($legal as $link)
                    <li>
                        <a href="#"
                            class="underline underline-offset-4 transition-colors hover:text-foreground">{{ $link }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</footer>
