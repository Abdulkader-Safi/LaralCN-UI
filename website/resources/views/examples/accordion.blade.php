<x-ui.accordion :items="[
    'a' => 'Is it accessible?',
    'b' => 'Is it styled?',
    'c' => 'Is it animated?',
]" class="w-full max-w-md">
    <x-slot:item_a>Yes. It follows the WAI-ARIA disclosure pattern.</x-slot:item_a>
    <x-slot:item_b>Yes. It uses your theme tokens out of the box.</x-slot:item_b>
    <x-slot:item_c>Yes. It slides open with the script the component ships.</x-slot:item_c>
</x-ui.accordion>
