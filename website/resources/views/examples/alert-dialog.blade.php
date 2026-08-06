<x-ui.alert-dialog title="Delete this project?"
    description="This removes the project and everything in it. It cannot be undone.">
    <x-slot:trigger>
        <x-ui.button variant="destructive">Delete project</x-ui.button>
    </x-slot:trigger>

    <x-slot:footer>
        <x-ui.button variant="outline" data-ui-alert-dialog-close>Cancel</x-ui.button>
        <x-ui.button variant="destructive" data-ui-alert-dialog-close>Delete</x-ui.button>
    </x-slot:footer>
</x-ui.alert-dialog>
