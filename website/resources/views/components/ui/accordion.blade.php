@props([
    'items' => [],
    'multiple' => false,
])

@php
    $rootClasses = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'divide-y divide-border rounded-md border border-border',
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
        <div>
            <h3>
                <button type="button"
                    @click="toggle(@js($key))"
                    x-bind:aria-expanded="open.includes(@js($key)).toString()"
                    class="flex w-full items-center justify-between px-4 py-4 text-sm font-medium transition-all hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
                    <span>{{ $label }}</span>
                    <svg class="h-4 w-4 shrink-0 transition-transform"
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
                x-cloak class="px-4 pb-4 text-sm text-muted-foreground">
                {{ ${'item_' . $key} ?? '' }}
            </div>
        </div>
    @endforeach
</div>
