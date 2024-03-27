<div>


    <x-v3-top-header>
       {{$record->title}}
       <!-- Slot 1 content not provided, default content will be displayed -->
       <x-slot name="slot2">
        <x-back-button :url="route('mooe.expense.list',['record'=> $record->m_o_o_e_group_id ])">BACK</x-back-button>
       </x-slot>
   </x-v3-top-header>
   <div class="bg-white p-4 rounded-lg">
       <form wire:submit="save">
           {{ $this->form }}
           <x-custom-button type="submit"  class="text-center justify-center">Save</x-custom-button>
        </form>

    </div>
    <x-filament-actions::modals />
</div>
