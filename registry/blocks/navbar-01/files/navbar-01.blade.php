{{--
    Every piece of content is a prop, so you can drive this navbar from a CMS.
    A link is either a plain string or ['label' => ..., 'href' => ...].
    An action is ['label' =>, 'href' =>, 'variant' =>]; give it an href and it
    renders as a link, leave href out and it stays a plain button. Variants are
    default, outline, secondary, ghost, link and destructive.
    Pass :menu-label="null" to drop the dropdown entirely.

    <x-ui.blocks.navbar-01
        brand="Acme"
        brand-href="/"
        :links="[
            ['label' => 'Product', 'href' => '/product'],
            ['label' => 'Pricing', 'href' => '/pricing'],
            'Customers',
        ]"
        menu-label="Resources"
        :menu-links="[
            ['label' => 'Docs', 'href' => '/docs'],
            ['label' => 'Changelog', 'href' => '/changelog'],
            ['label' => 'Status', 'href' => 'https://status.acme.com'],
        ]"
        :actions="[
            ['label' => 'Sign in', 'href' => route('login'), 'variant' => 'outline'],
            ['label' => 'Start free', 'href' => route('register'), 'variant' => 'default'],
        ]"
    />
--}}
@props([
    'brand' => 'LaralCN',
    'brandHref' => '#',
    'links' => ['Link One', 'Link Two', 'Link Three'],
    'menuLabel' => 'Link Four',
    'menuLinks' => ['Link Five', 'Link Six', 'Link Seven'],
    'actions' => [
        ['label' => 'Sign in', 'href' => null, 'variant' => 'outline'],
        ['label' => 'Get Started', 'href' => null, 'variant' => 'default'],
    ],
])

@php
    $link = static fn($item): array => is_array($item)
        ? $item + ['href' => '#']
        : ['label' => $item, 'href' => '#'];
@endphp

<header
    {{ $attributes->merge(['class' => 'sticky top-0 z-40 w-full border-b border-border bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60']) }}>
    <div
        class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        {{-- Logo --}}
        <a href="{{ $brandHref }}"
            class="flex items-center gap-2 font-semibold text-foreground">
            {{ $logo ?? '' }}
            @empty($logo)
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
            @endempty
            <span class="text-lg">{{ $brand }}</span>
        </a>

        {{-- Desktop navigation --}}
        <nav class="hidden items-center gap-1 lg:flex" aria-label="Main">
            @foreach ($links as $item)
                @php($entry = $link($item))
                <a href="{{ $entry['href'] }}"
                    class="rounded-md px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground">{{ $entry['label'] }}</a>
            @endforeach

            @if ($menuLabel)
                <x-ui.dropdown-menu>
                    <x-slot:trigger>
                        <button type="button"
                            class="inline-flex items-center gap-1 rounded-md px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground group-data-[state=open]/dropdown:bg-accent group-data-[state=open]/dropdown:text-accent-foreground">
                            {{ $menuLabel }}
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="size-4 transition-transform duration-200 group-data-[state=open]/dropdown:rotate-180"
                                aria-hidden="true">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </button>
                    </x-slot:trigger>

                    @foreach ($menuLinks as $item)
                        @php($entry = $link($item))
                        <a href="{{ $entry['href'] }}" role="menuitem"
                            class="block rounded-sm px-2 py-1.5 text-sm text-popover-foreground hover:bg-accent hover:text-accent-foreground">{{ $entry['label'] }}</a>
                    @endforeach
                </x-ui.dropdown-menu>
            @endif
        </nav>

        {{-- Desktop actions --}}
        <div class="hidden items-center gap-2 lg:flex">
            @foreach ($actions as $action)
                <x-ui.button :variant="$action['variant'] ?? 'default'"
                    :href="$action['href'] ?? null">{{ $action['label'] ?? '' }}</x-ui.button>
            @endforeach
        </div>

        {{-- Mobile menu --}}
        <div class="lg:hidden">
            <x-ui.sheet side="right">
                <x-slot:trigger>
                    <button type="button" aria-label="Open menu"
                        class="inline-flex size-10 items-center justify-center rounded-md text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="size-5"
                            aria-hidden="true">
                            <path d="M4 12h16" />
                            <path d="M4 6h16" />
                            <path d="M4 18h16" />
                        </svg>
                    </button>
                </x-slot:trigger>

                <nav class="flex flex-col gap-1 px-2 pt-2" aria-label="Mobile">
                    @foreach ($links as $item)
                        @php($entry = $link($item))
                        <a href="{{ $entry['href'] }}"
                            class="rounded-md px-3 py-2 text-sm font-medium text-foreground hover:bg-accent hover:text-accent-foreground">{{ $entry['label'] }}</a>
                    @endforeach

                    @if ($menuLabel)
                        <x-ui.collapsible class="flex flex-col">
                            <x-ui.collapsible.trigger
                                class="flex items-center justify-between rounded-md px-3 py-2 text-sm font-medium text-foreground hover:bg-accent hover:text-accent-foreground">
                                {{ $menuLabel }}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="size-4 transition-transform duration-200 group-data-[state=open]/collapsible:rotate-180"
                                    aria-hidden="true">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </x-ui.collapsible.trigger>

                            <x-ui.collapsible.content
                                class="ml-3 flex-col gap-1 border-l border-border pl-3 group-data-[state=open]/collapsible:flex">
                                @foreach ($menuLinks as $item)
                                    @php($entry = $link($item))
                                    <a href="{{ $entry['href'] }}"
                                        class="rounded-md px-3 py-2 text-sm text-muted-foreground hover:bg-accent hover:text-accent-foreground">{{ $entry['label'] }}</a>
                                @endforeach
                            </x-ui.collapsible.content>
                        </x-ui.collapsible>
                    @endif
                </nav>

                <x-slot:footer>
                    @foreach ($actions as $action)
                        <x-ui.button :variant="$action['variant'] ?? 'default'"
                            :href="$action['href'] ?? null"
                            class="w-full">{{ $action['label'] ?? '' }}</x-ui.button>
                    @endforeach
                </x-slot:footer>
            </x-ui.sheet>
        </div>
    </div>
</header>
