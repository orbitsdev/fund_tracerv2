<div class="">
    <x-v3-top-header>
        Year Options (For LIB)
         <!-- Slot 1 content not provided, default content will be displayed -->
         <x-slot name="slot2">
          <x-back-button :url="route('manage.content-management')">BACK</x-back-button>

         </x-slot>
     </x-v3-top-header>
     <div class="bg-white p-4 rounded-lg">

        {{ $this->table }}
    </div>
</div>
