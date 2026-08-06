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
    ];
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

<footer class="w-full border-t border-border bg-background">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8 lg:py-20">
        {{-- Newsletter --}}
        <div
            class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
            <div class="flex flex-col gap-1">
                <h3 class="text-sm font-semibold text-foreground">Join our
                    newsletter</h3>
                <p class="text-sm text-muted-foreground">Lorem ipsum dolor sit
                    amet, consectetur adipiscing elit.</p>
            </div>

            <div class="flex flex-col gap-2 lg:w-96">
                <form class="flex flex-col gap-2 sm:flex-row"
                    onsubmit="return false">
                    <label for="footer-02-email" class="sr-only">Email</label>
                    <x-ui.input id="footer-02-email" type="email"
                        placeholder="Enter your email" class="sm:flex-1" />
                    <x-ui.button variant="outline">Subscribe</x-ui.button>
                </form>
                <p class="text-xs text-muted-foreground">
                    By subscribing you agree to with our
                    <a href="#" class="underline underline-offset-4">Privacy
                        Policy</a>.
                </p>
            </div>
        </div>

        {{-- Logo + link columns --}}
        <div
            class="mt-12 grid grid-cols-1 gap-10 sm:grid-cols-2 lg:mt-20 lg:grid-cols-6 lg:gap-8">
            <a href="#"
                class="flex items-center gap-2 self-start font-semibold text-foreground">
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

        <div class="mt-12 border-t border-border pt-6">
            <div
                class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div
                    class="flex flex-col gap-3 text-sm text-muted-foreground md:flex-row md:items-center md:gap-6">
                    <p>&copy; {{ date('Y') }} LaralCN. All rights reserved.</p>
                    @foreach ($legal as $link)
                        <a href="#"
                            class="underline underline-offset-4 transition-colors hover:text-foreground">{{ $link }}</a>
                    @endforeach
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
</footer>
