<div>

    <x-v3-top-header>
        Maintenance and Other Operating Expenses (MOOE)
       <!-- Slot 1 content not provided, default content will be displayed -->
       <x-slot name="slot2">
        <x-back-button :url="route('mooe.index')">BACK</x-back-button>
       </x-slot>
   </x-v3-top-header>
   <div class="bg-white p-4 rounded-lg">

       <x-management-layout>

           {{ $this->table }}
        </x-management-layout>
    </div>
</div>
