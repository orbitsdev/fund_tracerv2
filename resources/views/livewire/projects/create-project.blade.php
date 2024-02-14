<div>
    <x-create-management-layout>

        <x-back-button :url="route('project.index')">BACK</x-back-button>

        <form wire:submit="create">
            {{ $this->form }}

            <x-custom-button type="submit" class="mt-4">
                Submit
            </x-custom-button>
        </form>

        <x-filament-actions::modals />
    </x-create-management-layout>
</div>
