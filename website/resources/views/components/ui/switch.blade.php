@props([
    'name' => null,
    'checked' => false,
    'value' => '1',
])

@php
    // A native checkbox carries the state: form submission, keyboard support
    // and :checked styling all come free, so this component ships no script.
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'inline-flex h-[1.15rem] w-8 shrink-0 cursor-pointer items-center rounded-full border border-transparent bg-input shadow-xs transition-colors has-[:checked]:bg-primary has-[:focus-visible]:border-ring has-[:focus-visible]:ring-[3px] has-[:focus-visible]:ring-ring/50 has-[:disabled]:cursor-not-allowed has-[:disabled]:opacity-50 dark:bg-input/80',
        $attributes->get('class'),
    );
@endphp

<label {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    <input type="checkbox" role="switch" class="peer sr-only"
        @if ($name) name="{{ $name }}" @endif value="{{ $value }}"
        @checked($checked) />
    <span
        class="pointer-events-none block size-4 rounded-full bg-background ring-0 transition-transform peer-checked:translate-x-[calc(100%-2px)]"></span>
</label>
