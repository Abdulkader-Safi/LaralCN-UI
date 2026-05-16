<x-ui.dropdown-menu>
    <x-slot:trigger>
        <x-ui.button variant="outline">Open menu</x-ui.button>
    </x-slot:trigger>

    <button role="menuitem"
        class="block w-full rounded-sm px-3 py-1.5 text-left text-sm hover:bg-accent hover:text-accent-foreground">
        Profile
    </button>
    <button role="menuitem"
        class="block w-full rounded-sm px-3 py-1.5 text-left text-sm hover:bg-accent hover:text-accent-foreground">
        Settings
    </button>
    <x-ui.separator class="my-1" />
    <button role="menuitem"
        class="block w-full rounded-sm px-3 py-1.5 text-left text-sm text-destructive hover:bg-accent">
        Sign out
    </button>
</x-ui.dropdown-menu>
