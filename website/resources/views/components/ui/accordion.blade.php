@props([
    'items' => [],
    'multiple' => false,
])

@php
    $rootClasses = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        '',
        $attributes->get('class'),
    );
@endphp

<div x-data="{
    multiple: @js((bool) $multiple),
    open: [],
    toggle(key) {
        if (this.open.includes(key)) {
            this.open = this.open.filter(k => k !== key);
        } else {
            this.open = this.multiple ? [...this.open, key] : [key];
        }
    },
}" class="{{ $rootClasses }}"
    {{ $attributes->except('class') }}>
    @foreach ($items as $key => $label)
        <div class="border-b last:border-b-0">
            <h3 class="flex">
                <button type="button"
                    @click="toggle(@js($key))"
                    x-bind:aria-expanded="open.includes(@js($key)).toString()"
                    class="flex flex-1 items-start justify-between gap-4 rounded-md py-4 text-left text-sm font-medium outline-none transition-all hover:underline focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] disabled:pointer-events-none disabled:opacity-50">
                    <span>{{ $label }}</span>
                    <svg class="pointer-events-none size-4 shrink-0 translate-y-0.5 text-muted-foreground transition-transform duration-200"
                        x-bind:class="open.includes(@js($key)) ?
                            'rotate-180' : ''"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        aria-hidden="true">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </button>
            </h3>
            <div x-show="open.includes(@js($key))" x-collapse
                x-cloak class="pb-4 pt-0 text-sm text-muted-foreground">
                {{ ${'item_' . $key} ?? '' }}
            </div>
        </div>
    @endforeach
</div>
