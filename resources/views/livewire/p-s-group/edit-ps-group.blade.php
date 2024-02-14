<div>
    <x-management-layout>

   <x-back-button :url="route('personal-service.index')">BACK</x-back-button>



    <p class=" text-2xl italic text-primary-600 mb-4">
        Personal Service > {{$record->title}}
    </p>
    <form wire:submit="save">
        {{ $this->form }}

        <x-custom-button type="submit"  class="text-center justify-center">Save</x-custom-button>
    </form>

    <x-filament-actions::modals />
</x-management-layout>
</div>
