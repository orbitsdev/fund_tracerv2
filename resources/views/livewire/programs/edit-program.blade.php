<div>
    <x-create-management-layout>

        <x-back-button :url="route('program.index')">BACK</x-back-button>
    <form wire:submit="save">
        {{ $this->form }}

        <x-custom-button type="submit">
            Update
        </x-custom-button>
    </form>

    <x-filament-actions::modals />
</x-create-management-layout>
</div>
