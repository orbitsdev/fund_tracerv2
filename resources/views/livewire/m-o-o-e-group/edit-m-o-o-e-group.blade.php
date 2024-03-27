<div>

    <x-v3-top-header>
        Maintenance and Other Operating Expenses > {{$record->title}}
       <!-- Slot 1 content not provided, default content will be displayed -->
       <x-slot name="slot2">
        <x-back-button :url="route('mooe.index')">BACK</x-back-button>
       </x-slot>
   </x-v3-top-header>
    <x-management-layout>
      
        <form wire:submit="save">
            {{ $this->form }}

            <x-custom-button type="submit"  class="text-center justify-center">Save</x-custom-button>
        </form>


        <x-filament-actions::modals />
    </x-management-layout>
</div>
