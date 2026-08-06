<div class="flex flex-col items-center gap-6">
    <x-ui.toggle-group name="align" variant="outline">
        <x-ui.toggle-group.item value="left" :pressed="true">Left</x-ui.toggle-group.item>
        <x-ui.toggle-group.item value="center">Center</x-ui.toggle-group.item>
        <x-ui.toggle-group.item value="right">Right</x-ui.toggle-group.item>
    </x-ui.toggle-group>

    <x-ui.toggle-group name="style" :multiple="true">
        <x-ui.toggle-group.item value="bold" :pressed="true">Bold</x-ui.toggle-group.item>
        <x-ui.toggle-group.item value="italic">Italic</x-ui.toggle-group.item>
        <x-ui.toggle-group.item value="underline">Underline</x-ui.toggle-group.item>
    </x-ui.toggle-group>
</div>
