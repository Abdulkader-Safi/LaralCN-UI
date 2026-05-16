<x-ui.tabs :tabs="['account' => 'Account', 'password' => 'Password']" default="account" class="w-full max-w-md">
    <x-slot:tab_account>
        <div
            class="rounded-md border border-border p-4 text-sm text-muted-foreground">
            Make changes to your account here.
        </div>
    </x-slot:tab_account>
    <x-slot:tab_password>
        <div
            class="rounded-md border border-border p-4 text-sm text-muted-foreground">
            Change your password here.
        </div>
    </x-slot:tab_password>
</x-ui.tabs>
