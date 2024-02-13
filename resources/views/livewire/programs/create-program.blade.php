<div>
    <x-create-management-layout>
        <form wire:submit="create">
            {{ $this->form }}

            <x-custom-button type="submit">
                Submit
            </x-custom-button>
        </form>

        <x-filament-actions::modals />

    </x-create-management-layout>
</div>
