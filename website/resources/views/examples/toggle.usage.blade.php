<x-ui.toggle name="bold" :pressed="true" aria-label="Bold">B</x-ui.toggle>
<x-ui.toggle variant="outline" name="italic">Italic</x-ui.toggle>

{{-- size: sm, md (default) or lg. value is submitted when pressed. --}}
<x-ui.toggle name="mode" value="grid" size="sm">Grid</x-ui.toggle>
<x-ui.toggle name="mode" value="list" size="lg">List</x-ui.toggle>
