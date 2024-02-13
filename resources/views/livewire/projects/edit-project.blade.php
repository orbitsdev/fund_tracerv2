<div>
    <x-create-management-layout>
        <form wire:submit="save">
            {{ $this->form }}

            <button type="submit">
                Submit
            </button>
        </form>

        <x-filament-actions::modals />
    </x-create-management-layout>
</div>
