<div>
    <x-create-management-layout>
        <x-back-button :url="route('project.index')">BACK </x-back-button>
        <form wire:submit="save">
            {{ $this->form }}

            <div class="mt-4">

                <x-custom-button type="submit">
                    Submit
                </x-custom-button>
            </div>
        </form>

        <x-filament-actions::modals />
    </x-create-management-layout>
</div>
