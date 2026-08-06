<x-ui.dropdown-menu>
    <x-slot:trigger>
        <x-ui.button variant="outline">Open menu</x-ui.button>
    </x-slot:trigger>

    <button role="menuitem"
        class="block w-full rounded-sm px-3 py-1.5 text-left text-sm hover:bg-accent hover:text-accent-foreground">
        Profile
    </button>
</x-ui.dropdown-menu>

{{-- align: start (default), center or end, relative to the trigger --}}
<x-ui.dropdown-menu align="end">
    <x-slot:trigger>
        <x-ui.button variant="ghost">Account</x-ui.button>
    </x-slot:trigger>

    <a href="/settings" role="menuitem"
        class="block rounded-sm px-3 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground">
        Settings
    </a>
</x-ui.dropdown-menu>
