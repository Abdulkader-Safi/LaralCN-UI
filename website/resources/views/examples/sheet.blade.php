<x-ui.sheet title="Edit profile"
    description="Make changes to your profile here. Click save when you're done.">
    <x-slot:trigger>
        <x-ui.button variant="outline">Open</x-ui.button>
    </x-slot:trigger>

    <div class="grid gap-4 px-4">
        <div class="grid gap-2">
            <x-ui.label for="sheet-name">Name</x-ui.label>
            <x-ui.input id="sheet-name" value="Pedro Duarte" />
        </div>
        <div class="grid gap-2">
            <x-ui.label for="sheet-username">Username</x-ui.label>
            <x-ui.input id="sheet-username" value="@peduarte" />
        </div>
    </div>

    <x-slot:footer>
        <x-ui.button>Save changes</x-ui.button>
    </x-slot:footer>
</x-ui.sheet>
