<x-ui.button x-data
    @click="window.dispatchEvent(new CustomEvent('toast', { detail: { title: 'Saved', description: 'Your changes have been saved.' } }))">
    Show toast
</x-ui.button>

<x-ui.toast />
