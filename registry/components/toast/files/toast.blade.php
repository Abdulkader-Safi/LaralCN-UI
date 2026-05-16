@props([
    'position' => 'bottom-right',
])

@php
    $anchor = match ($position) {
        'top-right' => 'top-4 right-4',
        'top-left' => 'top-4 left-4',
        'bottom-left' => 'bottom-4 left-4',
        default => 'bottom-4 right-4',
    };

    $regionClasses = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'fixed z-[100] flex flex-col gap-2 w-full max-w-sm',
        $anchor,
        $attributes->get('class'),
    );
@endphp

<div x-data="{
    toasts: [],
    add(detail) {
        const id = Date.now() + Math.random();
        this.toasts.push({ id, ...detail });
        setTimeout(() => this.remove(id), detail.duration ?? 4000);
    },
    remove(id) {
        this.toasts = this.toasts.filter(t => t.id !== id);
    },
}" @toast.window="add($event.detail)"
    class="{{ $regionClasses }}" role="region" aria-live="polite"
    {{ $attributes->except('class') }}>
    <template x-for="toast in toasts" :key="toast.id">
        <div x-transition role="status"
            class="pointer-events-auto flex items-start gap-3 rounded-md border border-border bg-background p-4 shadow-lg">
            <div class="flex-1">
                <p class="text-sm font-semibold" x-text="toast.title"></p>
                <p class="text-sm text-muted-foreground"
                    x-show="toast.description" x-text="toast.description"></p>
            </div>
            <button type="button"
                class="text-muted-foreground hover:text-foreground"
                aria-label="Dismiss" @click="remove(toast.id)">&times;</button>
        </div>
    </template>
</div>
