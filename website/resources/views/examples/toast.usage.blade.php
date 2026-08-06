<x-ui.button
    onclick="window.dispatchEvent(new CustomEvent('toast', { detail: { title: 'Saved', description: 'Your changes have been saved.' } }))">
    Show toast
</x-ui.button>

{{-- One region per page. position: bottom-right (default), bottom-left,
     top-right, top-left or top-center. --}}
<x-ui.toast position="top-center" />
