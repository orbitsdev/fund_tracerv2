<div>

    <x-v3-top-header>
        Personal Service >  {{$record->title}}
        <!-- Slot 1 content not provided, default content will be displayed -->
        <x-slot name="slot2">
            <x-back-button :url="route('personal-service.index')">BACK</x-back-button>

        </x-slot>
    </x-v3-top-header>
    <div class="bg-white p-4 rounded-lg">
    <x-management-layout>




            <div class="rounded-lg bg-trust-100 mb-4 text-gray-700 px-6  py-4 text-sm ">
                Make Sure You have already calculated the amount base on the specified options before you save
            </div>
            <form wire:submit="save">
                {{ $this->form }}

                <x-custom-button type="submit"  class="text-center justify-center">Save</x-custom-button>
            </form>

            <x-filament-actions::modals />
        </x-management-layout>
    </div>
</div>
