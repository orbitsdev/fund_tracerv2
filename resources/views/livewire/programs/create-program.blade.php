<div class="">
    <x-create-management-layout>

        <x-slot name="header">
            <x-back-button :url="route('program.index')">BACK</x-back-button>
            <p class="text-3xl">

                    Create Program
            </p>
        </x-slot>


        <form wire:submit="create">
            {{ $this->form }}

            <x-custom-button type="submit">
                Submit
            </x-custom-button>
        </form>

        <x-filament-actions::modals />

    </x-create-management-layout>
</div>
