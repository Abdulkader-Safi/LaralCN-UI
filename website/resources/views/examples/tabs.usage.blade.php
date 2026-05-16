<x-ui.tabs :tabs="['account' => 'Account', 'password' => 'Password']" default="account">
    <x-slot:tab_account>Make changes to your account here.</x-slot:tab_account>
    <x-slot:tab_password>Change your password here.</x-slot:tab_password>
</x-ui.tabs>
