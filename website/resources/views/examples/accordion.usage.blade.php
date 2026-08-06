<x-ui.accordion :items="['a' => 'Is it accessible?']">
    <x-slot:item_a>Yes. It follows the WAI-ARIA disclosure pattern.</x-slot:item_a>
</x-ui.accordion>

{{-- multiple: more than one panel can stay open at a time --}}
<x-ui.accordion :multiple="true" :items="['ship' => 'When do you ship?', 'returns' => 'What is your returns policy?']">
    <x-slot:item_ship>Same day for orders before 2pm.</x-slot:item_ship>
    <x-slot:item_returns>Thirty days, no questions asked.</x-slot:item_returns>
</x-ui.accordion>
