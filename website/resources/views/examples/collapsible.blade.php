<x-ui.collapsible class="w-full max-w-sm space-y-2">
    <div class="flex items-center justify-between gap-4 px-1">
        <h4 class="text-sm font-semibold">
            &commat;peduarte starred 3 repositories
        </h4>
        <x-ui.collapsible.trigger
            class="inline-flex size-8 items-center justify-center rounded-md hover:bg-accent hover:text-accent-foreground">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" class="size-4">
                <path d="m7 15 5 5 5-5" />
                <path d="m7 9 5-5 5 5" />
            </svg>
            <span class="sr-only">Toggle</span>
        </x-ui.collapsible.trigger>
    </div>
    <div class="rounded-md border px-4 py-2 font-mono text-sm">
        &commat;radix-ui/primitives
    </div>
    <x-ui.collapsible.content class="space-y-2">
        <div class="rounded-md border px-4 py-2 font-mono text-sm">
            &commat;radix-ui/colors
        </div>
        <div class="rounded-md border px-4 py-2 font-mono text-sm">
            &commat;stitches/react
        </div>
    </x-ui.collapsible.content>
</x-ui.collapsible>
