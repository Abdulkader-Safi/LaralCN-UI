{{-- Single select: submits align=center --}}
<x-ui.toggle-group name="align" variant="outline">
    <x-ui.toggle-group.item value="left">Left</x-ui.toggle-group.item>
    <x-ui.toggle-group.item value="center" :pressed="true">Center</x-ui.toggle-group.item>
    <x-ui.toggle-group.item value="right">Right</x-ui.toggle-group.item>
</x-ui.toggle-group>

{{-- Multi select: submits style[]=bold&style[]=italic --}}
<x-ui.toggle-group name="style" :multiple="true">
    <x-ui.toggle-group.item value="bold">Bold</x-ui.toggle-group.item>
    <x-ui.toggle-group.item value="italic">Italic</x-ui.toggle-group.item>
</x-ui.toggle-group>

{{-- size: sm, md (default) or lg, applied to every item --}}
<x-ui.toggle-group name="zoom" size="sm">
    <x-ui.toggle-group.item value="50">50%</x-ui.toggle-group.item>
    <x-ui.toggle-group.item value="100">100%</x-ui.toggle-group.item>
</x-ui.toggle-group>
