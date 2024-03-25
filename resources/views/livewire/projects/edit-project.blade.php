<div>
    <x-v3-top-header>
        Edit Project
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
</div>
