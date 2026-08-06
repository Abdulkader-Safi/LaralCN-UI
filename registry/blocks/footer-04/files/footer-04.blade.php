{{--
    Every piece of content is a prop, so you can drive this footer from a CMS.
    A link is either a plain string or ['label' => ..., 'href' => ...].
    An action is ['label' =>, 'href' =>, 'variant' =>]; give it an href and it
    renders as a link, leave href out and it stays a plain button. Variants are
    default, outline, secondary, ghost, link and destructive.
    A social is ['label' =>, 'href' =>, 'icon' =>] where icon is a key of the
    $icons map below ('facebook', 'instagram', 'x', 'linkedin', 'youtube'), or
    pass 'svg' => '<svg ...>' to use a mark of your own.

    <x-ui.blocks.footer-04
        brand="Acme"
        heading="Ship your next release without the release-day panic"
        text="Acme deploys, monitors and rolls back for teams that would rather build."
        :actions="[
            ['label' => 'Start free', 'href' => '/register', 'variant' => 'default'],
            ['label' => 'Book a demo', 'href' => '/demo', 'variant' => 'outline'],
        ]"
        :columns="[
            ['links' => [
                ['label' => 'Pricing', 'href' => '/pricing'],
                ['label' => 'Changelog', 'href' => '/changelog'],
            ]],
            ['links' => [
                ['label' => 'Docs', 'href' => '/docs'],
                ['label' => 'Support', 'href' => '/support'],
            ]],
        ]"
        :socials="[
            ['label' => 'X', 'href' => 'https://x.com/acme', 'icon' => 'x'],
            ['label' => 'LinkedIn', 'href' => 'https://linkedin.com/company/acme', 'icon' => 'linkedin'],
        ]"
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
    'heading' => 'Medium length footer heading goes here',
    'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique.',
    'actions' => [
        ['label' => 'Button', 'href' => null, 'variant' => 'default'],
        ['label' => 'Button', 'href' => null, 'variant' => 'outline'],
    ],
    'columns' => [
        ['links' => ['Link One', 'Link Two', 'Link Three', 'Link Four', 'Link Five']],
        ['links' => ['Link Six', 'Link Seven', 'Link Eight', 'Link Nine', 'Link Ten']],
    ],
    'socials' => [
        ['label' => 'Facebook', 'icon' => 'facebook'],
        ['label' => 'Instagram', 'icon' => 'instagram'],
        ['label' => 'X', 'icon' => 'x'],
        ['label' => 'LinkedIn', 'icon' => 'linkedin'],
        ['label' => 'Youtube', 'icon' => 'youtube'],
    ],
    'legal' => ['Privacy Policy', 'Terms of Service', 'Cookies Settings'],
    'copyright' => null,
])

@php
    $link = static fn($item): array => is_array($item)
        ? $item + ['href' => '#']
        : ['label' => $item, 'href' => '#'];

    $icons = [
        'facebook' =>
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>',
        'instagram' =>
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5" aria-hidden="true"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>',
        'x' =>
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4" aria-hidden="true"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg>',
        'linkedin' =>
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>',
        'youtube' =>
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5" aria-hidden="true"><path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/><path d="m10 15 5-3-5-3z"/></svg>',
    ];
@endphp

<footer {{ $attributes->merge(['class' => 'w-full bg-background']) }}>
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8 lg:py-20">
        {{-- Bordered card --}}
        <div class="rounded-lg border border-border p-6 lg:p-10">
            <div class="grid grid-cols-1 gap-10 lg:grid-cols-2 lg:gap-16">
                {{-- Pitch --}}
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
                                    stroke-linecap="round"
                                    stroke-linejoin="round" class="size-5"
                                    aria-hidden="true">
                                    <path d="M12 2 2 7l10 5 10-5-10-5Z" />
                                    <path d="m2 17 10 5 10-5" />
                                    <path d="m2 12 10 5 10-5" />
                                </svg>
                            </span>
                        @endempty
                        <span class="text-lg">{{ $brand }}</span>
                    </a>

                    <h2
                        class="text-3xl font-bold tracking-tight text-foreground md:text-4xl lg:text-5xl">
                        {{ $heading }}
                    </h2>

                    <p class="text-sm text-muted-foreground">{{ $text }}</p>

                    <div class="flex flex-wrap items-center gap-3">
                        @foreach ($actions as $action)
                            <x-ui.button :variant="$action['variant'] ?? 'default'"
                                :href="$action['href'] ?? null">{{ $action['label'] ?? '' }}</x-ui.button>
                        @endforeach
                    </div>
                </div>

                {{-- Links + socials --}}
                <div
                    class="flex flex-col justify-between gap-10 lg:items-end lg:text-right">
                    <div class="grid grid-cols-2 gap-8">
                        @foreach ($columns as $column)
                            <ul class="flex flex-col gap-2">
                                @foreach ($column['links'] ?? [] as $item)
                                    @php($entry = $link($item))
                                    <li>
                                        <a href="{{ $entry['href'] }}"
                                            class="text-sm text-muted-foreground transition-colors hover:text-foreground">{{ $entry['label'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>

                    <ul class="flex items-center gap-4">
                        @foreach ($socials as $social)
                            <li>
                                <a href="{{ $social['href'] ?? '#' }}"
                                    aria-label="{{ $social['label'] ?? '' }}"
                                    class="flex size-6 items-center justify-center text-foreground transition-opacity hover:opacity-70">
                                    {!! $social['svg'] ?? ($icons[$social['icon'] ?? ''] ?? '') !!}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div
            class="mt-6 flex flex-col-reverse gap-4 text-sm text-muted-foreground md:flex-row md:items-center md:justify-between">
            <p>{{ $copyright ?? '© ' . date('Y') . ' ' . $brand . '. All rights reserved.' }}
            </p>
            <ul class="flex flex-col gap-3 md:flex-row md:gap-6">
                @foreach ($legal as $item)
                    @php($entry = $link($item))
                    <li>
                        <a href="{{ $entry['href'] }}"
                            class="underline underline-offset-4 transition-colors hover:text-foreground">{{ $entry['label'] }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</footer>
