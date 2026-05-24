@props([
    'tabs' => [],
    'default' => null,
])

@php
    $active = $default ?? array_key_first($tabs);

    $listClasses = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'inline-flex h-9 w-fit items-center justify-center rounded-lg bg-muted p-[3px] text-muted-foreground',
        $attributes->get('class'),
    );
@endphp

<div x-data="{ active: @js($active) }" class="flex flex-col gap-2"
    {{ $attributes->except('class') }}>
    <div role="tablist" class="{{ $listClasses }}">
        @foreach ($tabs as $key => $label)
            <button type="button" role="tab"
                @click="active = @js($key)"
                x-bind:aria-selected="(active === @js($key)).toString()"
                x-bind:class="active === @js($key) ?
                    'bg-background text-foreground shadow-sm' : ''"
                class="inline-flex h-[calc(100%-1px)] flex-1 items-center justify-center gap-1.5 whitespace-nowrap rounded-md border border-transparent px-2 py-1 text-sm font-medium transition-[color,box-shadow] focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50">
                {{ $label }}
            </button>
        @endforeach
    </div>

    @foreach ($tabs as $key => $label)
        <div role="tabpanel" x-show="active === @js($key)"
            x-cloak class="flex-1 outline-none">
            {{ ${'tab_' . $key} ?? '' }}
        </div>
    @endforeach
</div>
