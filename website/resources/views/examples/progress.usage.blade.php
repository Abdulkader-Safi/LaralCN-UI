<x-ui.progress :value="66" />

{{-- max rescales the bar: 30 out of 120 renders as 25% --}}
<x-ui.progress :value="30" :max="120" />
