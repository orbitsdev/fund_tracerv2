<div>

    @if(session('success'))
    <div class="alert alert-success animate-pulse bg-trust-200 rounded text-trust-800 p-4 mb-2 flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif


    <div class=" grid grid-cols-12">
        <div class="col-span-8">
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

        <div class="col-span-4 p-4 ml-4 rounded bg-white">
                
            
            <div>
                
                <x-line-message> FINANCE MANAGER</x-line-message>

            </div>
            
            @if (!empty($record->user))
            <div class="flex items-center justify-end">

                {{ ($this->removeFinanceManagerAction)(['record' => $record->id]) }} <span
                    class=" text-gray-400 text-xs"> (REMOVE) </span>
            </div>
            <div class="flex items-center justify-between">     
              

                <div class="mt-2 w-full flex flex-col justify-center items-center  text-sm text-gray-500">  
                    <div class=" ">
                        <a href="
                        {{$record->user?->getUserImage()}}" target="_blank">
                        <img src="{{$record->user?->getUserImage()}}" alt="" class="h-10 w-10 rounded-full bg-gray-100">
                    </a>
                    </div>
                    <div class="flex-1 mt-2 text-center">
                        <h3 class="font-medium text-gray-900">{{$record->user?->getFullName()}}</h3>
                        <p><time datetime="2021-07-16 " class="">{{$record->user?->email}}</time></p>
                    </div>
                </div>
              
            </div>
            <div class="mt-4 mx-auto w-full  flex  justify-center">
                {{($this->viewAccountDetailsAction)(['record'=> $record])}}
            </div>
            @else

            <div class="text-center mt-4 text-gray-600">
                <svg  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mx-auto">
                    <path stroke-linecap="round"  stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                  </svg>
                  
                <h3 class="mt-2 text-sm font-semibold ">No One Was Assigned</h3>
                <div class="mt-2">
                    {{ ($this->addFinanceManagerAction)(['record' => $record->id]) }} 
                </div>
              </div>
            {{-- <div class="flex items-center justify-center">

                
                <div class="mt-4">
                    <p class="text-center text-gray-600">NONE</p>
                @if (empty($record->user))
                    
                    {{ ($this->addFinanceManagerAction)(['record' => $record->id]) }} 
                    
                    @endif
                </div>
            </div> --}}
            @endif
            <div>
                
                <x-line-message> STAFF</x-line-message>

            </div>
            <div class="mt-2 flex space-x-4 text-sm text-gray-500">  
                <div class="flex-none ">
                  <img src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80" alt="" class="h-10 w-10 rounded-full bg-gray-100">
                </div>
                <div class="flex-1 ">
                  <h3 class="font-medium text-gray-900">Emily Selman</h3>
                  <p><time datetime="2021-07-16">July 16, 2021</time></p>
                </div>
            </div>
{{-- 
            <div>
                @if (empty($record->user))
                    <div class="flex items-center">
    

                        {{ ($this->addFinanceManagerAction)(['record' => $record->id]) }} <span
                            class="ml-2 text-gray-700"> Finance Manager</span>
                    </div>
                @else
                    <div>
                        <h1>Finacne Manager</h1>
                        <p class="mt-2">
                            {{ $record->user?->getFullName() }}

                        </p>
                    </div>
                @endif

            </div>
           
             --}}


        </div>
        <x-filament-actions::modals />

    </div>
