<div class="">

    <x-v3-top-header>
        Create Project
        <!-- Slot 1 content not provided, default content will be displayed -->
        <x-slot name="slot2">
           <x-back-button :url="route('project.index')">BACK</x-back-button>
        </x-slot>
    </x-v3-top-header>
    
      
  


    <form wire:submit="create">
        {{ $this->form }}

        <div class="flex items-center justify-center">  

            <x-custom-button type="submit" class="mt-4  text-center flex items-center justify-center">
                Submit
            </x-custom-button>
        </div>
    </form>
    <div class="mb-4"></div>


    {{-- <x-create-management-layout>
        <x-back-button :url="route('project.index')">BACK</x-back-button>


        <form wire:submit="create">
            {{ $this->form }}

            <x-custom-button type="submit" class="mt-4">
                Submit
            </x-custom-button>
        </form>

        <x-filament-actions::modals />
    </x-create-management-layout> --}}
</div>
