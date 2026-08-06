@php
    $links = ['Link One', 'Link Two', 'Link Three', 'Link Four', 'Link Five'];
    $legal = ['Privacy Policy', 'Terms of Service', 'Cookies Settings'];
@endphp

<footer class="w-full border-t border-border bg-background">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8 lg:py-20">
        <div
            class="flex flex-col gap-10 lg:flex-row lg:items-start lg:justify-between">
            {{-- Logo + inline links --}}
            <div class="flex flex-col gap-6">
                <a href="#"
                    class="flex items-center gap-2 self-start font-semibold text-foreground">
                    <span
                        class="flex size-8 items-center justify-center rounded-md bg-primary text-primary-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="size-5"
                            aria-hidden="true">
                            <path d="M12 2 2 7l10 5 10-5-10-5Z" />
                            <path d="m2 17 10 5 10-5" />
                            <path d="m2 12 10 5 10-5" />
                        </svg>
                    </span>
                    <span class="text-lg">LaralCN</span>
                </a>

                <ul class="flex flex-col gap-3 sm:flex-row sm:gap-6">
                    @foreach ($links as $link)
                        <li>
                            <a href="#"
                                class="text-sm font-medium text-foreground transition-opacity hover:opacity-70">{{ $link }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Subscribe --}}
            <div class="flex flex-col gap-2 lg:w-96">
                <h3 class="text-sm font-semibold text-foreground">Subscribe</h3>
                <form class="flex flex-col gap-2 sm:flex-row"
                    onsubmit="return false">
                    <label for="footer-08-email" class="sr-only">Email</label>
                    <x-ui.input id="footer-08-email" type="email"
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

        {{-- Oversized wordmark. The clamp is tuned to fill the container with "LaralCN"; retune the max when you change the word or the font. --}}
        <p
            class="mt-12 text-[clamp(2.5rem,25vw,24rem)] font-bold leading-none tracking-tight text-foreground">
            LaralCN
        </p>

        <div
            class="mt-12 flex flex-col gap-4 border-t border-border pt-6 text-sm text-muted-foreground md:flex-row md:items-center md:justify-between">
            <ul class="flex flex-col gap-3 md:flex-row md:gap-6">
                @foreach ($legal as $link)
                    <li>
                        <a href="#"
                            class="underline underline-offset-4 transition-colors hover:text-foreground">{{ $link }}</a>
                    </li>
                @endforeach
            </ul>
            <p>&copy; {{ date('Y') }} LaralCN. All rights reserved.</p>
        </div>
    </div>
</footer>
