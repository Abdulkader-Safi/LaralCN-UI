<div class="flex w-full max-w-sm flex-col gap-6">
    <x-ui.slider name="volume" :value="50" />
    <x-ui.slider name="balance" :min="0" :max="10" :step="1" :value="3" />
    <x-ui.slider name="disabled" :value="25" disabled />
</div>
