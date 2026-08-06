{{--
    Every piece of content is a prop, so you can drive this footer from a CMS.
    A link is either a plain string or ['label' => ..., 'href' => ...].
    The wordmark defaults to `brand`; set it separately for a longer legal name,
    and retune the clamp below if the word no longer fills the container.

    <x-ui.blocks.footer-08
        brand="Acme"
        wordmark="Acme Cloud"
        :links="[
            ['label' => 'Pricing', 'href' => '/pricing'],
            ['label' => 'Docs', 'href' => '/docs'],
            ['label' => 'Changelog', 'href' => '/changelog'],
            'Careers',
        ]"
        newsletter-title="Ship notes"
        :form-action="route('newsletter.store')"
        privacy-href="/privacy"
        :legal="[
            ['label' => 'Privacy', 'href' => '/privacy'],
            ['label' => 'Terms', 'href' => '/terms'],
        ]"
        copyright="© 2026 Acme Pty Ltd"
    />
--}}
@props([
    'brand' => 'LaralCN',
    'brandHref' => '#',
    'wordmark' => null,
    'links' => ['Link One', 'Link Two', 'Link Three', 'Link Four', 'Link Five'],
    'newsletterTitle' => 'Subscribe',
    'formAction' => null,
    'emailPlaceholder' => 'Enter your email',
    'subscribeLabel' => 'Subscribe',
    'privacyHref' => '#',
    'legal' => ['Privacy Policy', 'Terms of Service', 'Cookies Settings'],
    'copyright' => null,
])

@php
    $link = static fn($item): array => is_array($item)
        ? $item + ['href' => '#']
        : ['label' => $item, 'href' => '#'];
@endphp

<footer {{ $attributes->merge(['class' => 'w-full border-t border-border bg-background']) }}>
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8 lg:py-20">
        <div
            class="flex flex-col gap-10 lg:flex-row lg:items-start lg:justify-between">
            {{-- Logo + inline links --}}
            <div class="flex flex-col gap-6">
                <a href="{{ $brandHref }}"
                    class="flex items-center gap-2 self-start font-semibold text-foreground">
                    {{ $logo ?? '' }}
                    @empty($logo)
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
                    @endempty
                    <span class="text-lg">{{ $brand }}</span>
                </a>

                <ul class="flex flex-col gap-3 sm:flex-row sm:gap-6">
                    @foreach ($links as $item)
                        @php($entry = $link($item))
                        <li>
                            <a href="{{ $entry['href'] }}"
                                class="text-sm font-medium text-foreground transition-opacity hover:opacity-70">{{ $entry['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Subscribe --}}
            <div class="flex flex-col gap-2 lg:w-96">
                <h3 class="text-sm font-semibold text-foreground">
                    {{ $newsletterTitle }}</h3>
                <form class="flex flex-col gap-2 sm:flex-row"
                    @if ($formAction) action="{{ $formAction }}" method="post" @else onsubmit="return false" @endif>
                    @if ($formAction)
                        @csrf
                    @endif
                    <label for="footer-08-email" class="sr-only">Email</label>
                    <x-ui.input id="footer-08-email" type="email" name="email"
                        placeholder="{{ $emailPlaceholder }}" class="sm:flex-1" />
                    <x-ui.button type="submit"
                        variant="outline">{{ $subscribeLabel }}</x-ui.button>
                </form>
                <p class="text-xs text-muted-foreground">
                    {{ $disclaimer ?? '' }}
                    @empty($disclaimer)
                        By subscribing you agree to with our
                        <a href="{{ $privacyHref }}"
                            class="underline underline-offset-4">Privacy Policy</a>.
                    @endempty
                </p>
            </div>
        </div>

        {{-- Oversized wordmark. The clamp is tuned to fill the container with "LaralCN"; retune the max when you change the word or the font. --}}
        <p
            class="mt-12 text-[clamp(2.5rem,25vw,24rem)] font-bold leading-none tracking-tight text-foreground">
            {{ $wordmark ?? $brand }}
        </p>

        <div
            class="mt-12 flex flex-col gap-4 border-t border-border pt-6 text-sm text-muted-foreground md:flex-row md:items-center md:justify-between">
            <ul class="flex flex-col gap-3 md:flex-row md:gap-6">
                @foreach ($legal as $item)
                    @php($entry = $link($item))
                    <li>
                        <a href="{{ $entry['href'] }}"
                            class="underline underline-offset-4 transition-colors hover:text-foreground">{{ $entry['label'] }}</a>
                    </li>
                @endforeach
            </ul>
            <p>{{ $copyright ?? '© ' . date('Y') . ' ' . $brand . '. All rights reserved.' }}
            </p>
        </div>
    </div>
</footer>
