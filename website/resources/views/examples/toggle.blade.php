<div class="flex items-center gap-2">
    <x-ui.toggle name="bold" :pressed="true" aria-label="Bold">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" aria-hidden="true">
            <path d="M6 12h9a4 4 0 0 1 0 8H7a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h7a4 4 0 0 1 0 8" />
        </svg>
    </x-ui.toggle>

    <x-ui.toggle name="italic" aria-label="Italic">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" aria-hidden="true">
            <line x1="19" x2="10" y1="4" y2="4" />
            <line x1="14" x2="5" y1="20" y2="20" />
            <line x1="15" x2="9" y1="4" y2="20" />
        </svg>
    </x-ui.toggle>

    <x-ui.toggle variant="outline" name="underline">Underline</x-ui.toggle>
    <x-ui.toggle size="sm" name="small">Small</x-ui.toggle>
    <x-ui.toggle size="lg" name="large">Large</x-ui.toggle>
</div>
