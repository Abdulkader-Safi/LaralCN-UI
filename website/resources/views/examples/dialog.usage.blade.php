<x-ui.dialog title="Are you sure?" description="This action cannot be undone.">
    <x-slot:trigger>
        <x-ui.button variant="outline">Open dialog</x-ui.button>
    </x-slot:trigger>

    <p class="text-sm text-muted-foreground">Dialog body content.</p>

    <x-slot:footer>
        <x-ui.button variant="outline"
            x-on:click="open = false">Cancel</x-ui.button>
        <x-ui.button variant="destructive">Delete</x-ui.button>
    </x-slot:footer>
</x-ui.dialog>
