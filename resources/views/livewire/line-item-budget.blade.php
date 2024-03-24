<div>

    <x-create-management-layout>
        {{-- <div class="p-2 bg-indigo-100 rounded-md drop-shadow-sm mb-2">

        </div> --}}

        <x-back-button style="justify-start" :url="route('project.line-item-budget',['record' => $record->project->id])">
            Back
        </x-bacl-button>
        {{-- {{$record}} --}}
        {{-- @dump($record) --}}
        <div class="relative ">
           @if($record->status != App\Models\ProjectYear::STATUS_FOR_EDITING)
           <div class="absolute z-10 inset-0 bg-gray-500 bg-opacity-50 backdrop-blur flex items-center justify-center hover:cursor-not-allowed">
            <div class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-72 h-72">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>
                <p class="text-4xl uppercase mt-10 "> {{$record->status}}</p>
            </div>
        </div>
           @endif

            

        <div class="mb-4">
            {{-- <p>{{$record->project->title}}</p> --}}
            <p class="uppercase text-primary-700 text-4xl  font-medium"> {{ $record->project->title }}</p>
            <p class="text-primary-700 text-4xl  font-medium mt-2"> {{ $record->year->title }}</p>
        </div>
        <div>
            <p class="text-primary-600 text-2xl font-medium"> I. Personal Service</p>
            <div class="mt-2">
                {{ $this->addPersonalServiceAction }}
            </div>

            <div class="mt-2">
                {{-- @dump($personal_services) --}}
                @forelse ($personal_services as $cost_type => 
                
                $personal_service)

                <div class="">
                    <p class="font-bold text-gray-600">
                        {{ $cost_type }} 
                    </p>
                    <div class="ml-4">
                        @foreach ($personal_service as $indirect_cost_type => $groups)
                     
                            <div class="ml-4">
                                <p class="font-medium text-gray-600">
                                            {{$indirect_cost_type}}
                                </p>

                                @foreach ($groups as $group_title => $expense)
                                    
                                 <div class="flex justify-between items-center border-b hover:bg-gray-50">
                                    <div class="ml-4 mr-4 flex justify-between text-gray-600 w-full">
                                        <p class="italic text-sm text-gray-500">
                                            {{ $expense->displaySelectedPS() }}
                                        </p>
                                        <p>
                                            {{ number_format($expense->amount) }}
                                        </p>
                                    </div>
                                    <div class="mb-2 flex">
                                        <div class="mr-2">
                                            {{ ($this->editPersonalServiceAction)(['ps' => $expense->id]) }}
                                        </div>
                                        <div class="mr-2">
                                            {{ ($this->deleteAction)(['ps' => $expense->id]) }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
            @endforelse
            
            </div>
            {{-- <div class="mt-4 flex justify-between p-2 bg-gray-100">
                <div>

                </div>
                <div class="flex font-bold">

                    <p class=" ">
                        Total DC
                    </p>
                    <p class="w-[200px] text-end mr-6">
                        {{number_format($total_dc)}}
                    </p>
                </div>
            </div>
            <div class="mt-4 flex justify-between p-2 bg-gray-100">
                <div>

                </div>
                <div class="flex font-bold">

                    <p class=" ">
                        Total IC SKSU
                    </p>
                    <p class="w-[200px] text-end mr-6">
                        {{number_format($total_sksu)}}
                    </p>
                </div>
            </div>
            <div class="mt-4 flex justify-between p-2 bg-gray-100">
                <div>

                </div>
                <div class="flex font-bold">

                    <p class=" ">
                        Total IC PCAARRD
                    </p>
                    <p class="w-[200px] text-end mr-6">
                        {{number_format($total_pcaarrd)}}
                    </p>
                </div>
            </div>
           --}}
           @if($record->getActualTotalPS() > 0)
            <div class="pr-8 flex justify-between p-1 bg-gray-100 ">
                <div>

                </div>
                <div class="flex font-medium">

                    <p class=" ">
                        Sub-total for PS
                    </p>
                    <p class="w-[200px] text-end mr-6">
                        {{ number_format($record->getActualTotalPS()) }}
                    </p>
                </div>
            </div>
            @endif

        </div>
        <div class="mt-6">
            <p class="text-primary-600 text-2xl font-medium"> II. Maintenance and Other Operating Expenses</p>
            <div class="mt-2">
                {{ $this->addMOOEAction }}
            </div>

            <div class="mt-2">
                {{-- @dump($mooes) --}}
                @forelse ($mooes as $cost_type => $mooe)
                    <div class="mt-4">
                        <p class="font-bold text-gray-600">

                            {{ $cost_type }}
                        </p>
                        <div class="ml-4">
                           
                            @foreach ($mooe as $group_title => $groups)
                                <div class="ml-4
                                    <p class="font-medium text-gray-600">
                                        {{ $group_title }}

                                    </p>
                                    @foreach ($groups as $key => $expense)
                                        <div class="flex justify-between   items-center border-b hover:bg-gray-50">

                                            <div class="ml-4 mr-4  flex   justify-between  text-gray-600 w-full    ">
                                                <p class="italic text-sm text-gray-500">
                                                  {{ $expense->m_o_o_e_expense->title }}
                                                 
                                                </p>
                                                <p>
                                                    {{ number_format($expense->amount) }}
                                                </p>

                                            </div>

                                            <div class="mb-2 flex">
                                                <div class="mr-2">
                                                    {{ ($this->editMooeAction)(['mooe' => $expense->id]) }}
                                                </div>
                                                <div class="mr-2">
                                                    {{ ($this->deleteMooeAction)(['mooe' => $expense->id]) }}

                                                </div>
                                                
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty

                @endforelse
            </div>


            {{-- <div class="mt-4 flex justify-between p-2 bg-gray-100">
                <div>

                </div>
                <div class="flex font-bold">

                    <p class=" ">
                        Total DC
                    </p>
                    <p class="w-[200px] text-end mr-6">
                        {{number_format($total_dc)}}
                    </p>
                </div>
            </div>
            <div class="mt-4 flex justify-between p-2 bg-gray-100">
                <div>

                </div>
                <div class="flex font-bold">

                    <p class=" ">
                        Total IC SKSU
                    </p>
                    <p class="w-[200px] text-end mr-6">
                        {{number_format($total_sksu)}}
                    </p>
                </div>
            </div>
            <div class="mt-4 flex justify-between p-2 bg-gray-100">
                <div>

                </div>
                <div class="flex font-bold">

                    <p class=" ">
                        Total IC PCAARRD
                    </p>
                    <p class="w-[200px] text-end mr-6">
                        {{number_format($total_pcaarrd)}}
                    </p>
                </div>
            </div>
           --}}
           @if($record->getActualTotalMOOE() > 0)
            <div class="pr-8 flex justify-between p-1 bg-gray-100 ">
                <div>

                </div>
                <div class="flex font-medium">

                    <p class=" ">
                        Sub-total for MOOE
                    </p>
                    <p class="w-[200px] text-end mr-6">
                        {{ number_format($record->getActualTotalMOOE()) }}
                    </p>
                </div>
            </div>
            @endif

        </div>
        <div class="mt-6">
            <p class="text-primary-600 text-2xl font-medium"> III Capital Outlay</p>
            <div class="mt-2">
                {{ $this->addCOAction }}
            </div>
            <div class="mt-2">
                @forelse ($cos as $cost_type => $groups)
                    <div class="mt-4">
                        <p class="font-bold text-gray-600">

                            {{ $cost_type }}
                        </p>

                        @foreach ($groups as $key => $expense)

                            <div class="flex justify-between   items-center border-b hover:bg-gray-50">

                                <div class="ml-4 mr-4  flex   justify-between  text-gray-600 w-full    ">
                                    <p class="italic text-sm text-gray-500">
                                       ({{$expense->quantity}}) {{ $expense->description }} <span class="text-xs">({{number_format($expense->amount)}} / Per item)</span>
                                    </p>
                                    <p>
                                        {{ number_format($expense->new_amount) }}
                                    </p>

                                </div>

                                <div class="mb-2 flex">
                                    <div class="mr-2">
                                    {{ ($this->editCOAction)(['co' => $expense->id]) }}
                                </div>
                                <div class="mr-2">
                                    {{ ($this->deleteCoAction)(['co' => $expense->id]) }}

                                </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                @empty

                @endforelse
            </div>
            @if($record->getActualTotalCO() > 0)


            <div class="pr-8 flex justify-between p-1 bg-gray-100 ">
                <div>

                </div>
                <div class="flex font-medium">

                    <p class=" ">
                        Sub-total for CO
                    </p>
                    <p class="w-[200px] text-end mr-6">
                        {{ number_format($record->getActualTotalCO()) }}
                    </p>
                </div>
            </div>
            @endif

        </div>
        @if($record->getYearActualBudget()> 0)
        <div>

            <div class="mt-4 pr-8 flex justify-between text-xl mb-8   p-2 text-system-800 rounded">
                <div>
                    <p class=" font-bold">
                        {{$record->year->title}}
                    </p>
                </div>
                <div class="flex font-bold">

                    <p class=" ">
                        Total Budget:
                    </p>
                    <p class="w-[200px] text-end mr-6">
                        {{ number_format($record->getYearActualBudget()) }}
                    </p>
                </div>
            </div>

        </div>
        @endif
    </div>
    <div class="mb-20 border-t border-gray-900/10 pt-8 sm:mt-20 lg:mt-24 lg:flex lg:items-center lg:justify-between">
        <div>
         
        </div>
        {{-- @dump($record) --}}
        <div class="mt-6 sm:flex sm:max-w-md lg:mt-0">
       
        @if($record->status == App\Models\ProjectYear::STATUS_FOR_EDITING)
            {{ $this->forReviewAction }}
            @elseif($record->status == App\Models\ProjectYear::STATUS_FOR_REVIEW)
            
            {{ $this->cancelReview }}
            @endif
        </div>
      </div>


      <div class="">
          <x-filament-actions::modals  />

      </div>
    </x-create-management-layout>
</div>
