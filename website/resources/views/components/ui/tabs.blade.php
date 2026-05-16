@props([
    'tabs' => [],
    'default' => null,
])

@php
    $active = $default ?? array_key_first($tabs);

    $listClasses = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'inline-flex h-10 items-center justify-center rounded-md bg-muted p-1 text-muted-foreground',
        $attributes->get('class'),
    );
@endphp

<div x-data="{ active: @js($active) }" {{ $attributes->except('class') }}>
    <div role="tablist" class="{{ $listClasses }}">
        @foreach ($tabs as $key => $label)
            <button type="button" role="tab"
                @click="active = @js($key)"
                x-bind:aria-selected="(active === @js($key)).toString()"
                x-bind:class="active === @js($key) ?
                    'bg-background text-foreground shadow-sm' : ''"
                class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                {{ $label }}
            </button>
        @endforeach
    </div>

    @foreach ($tabs as $key => $label)
        <div role="tabpanel" x-show="active === @js($key)"
            x-cloak
            class="mt-2 ring-offset-background focus-visible:outline-none">
            {{ ${'tab_' . $key} ?? '' }}
        </div>
    @endforeach
</div>
