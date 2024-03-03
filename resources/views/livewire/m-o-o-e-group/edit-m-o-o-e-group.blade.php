<div>
    <x-management-layout>
        <div class="flex justify-end">
            <x-back-button :url="route('mooe.index')">BACK</x-back-button>

        </div>
        <p class="my-2 text-2xl italic text-primary-600 mb-4">
            Maintenance and Other Operating Expenses > {{$record->title}}
        </p>
        <form wire:submit="save">
            {{ $this->form }}

            <x-custom-button type="submit"  class="text-center justify-center">Save</x-custom-button>
        </form>


        <x-filament-actions::modals />
    </x-management-layout>
</div>
