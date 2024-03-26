<div class="mb-20 ">

    <div class=" grid grid-cols-12">

    <div class="col-span-9">
        <x-v3-top-header>
            {{ $record->project->title }} ({{ $record->year->title }} LIB)
            <!-- Slot 1 content not provided, default content will be displayed -->
            <x-slot name="slot2">
                <x-back-button style="justify-start" :url="route('project.line-item-budget', ['record' => $record->project->id])">
                    Back
                    </x-bacl-button>
            </x-slot>
        </x-v3-top-header>


        <div class="relative mt-4 bg-white p-4 rounded">
            @if ($record->status != App\Models\ProjectYear::STATUS_FOR_EDITING)
                <div
                    class="absolute z-10 inset-0 bg-gray-500 bg-opacity-50 backdrop-blur flex items-center justify-center hover:cursor-not-allowed rounded">
                    <div class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-72 h-72">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                        <p class="text-4xl uppercase mt-10 "> {{ $record->status }}</p>
                    </div>
                </div>
            @endif




            <div class="">
                <div class="flex items-center border-b rounded pb-3">
                    <p class="text-primary-600 text-xl font-medium mr-4"> I. Personal Service</p>
                    <div class="mt-1">
                        {{ $this->addPersonalServiceAction }}
                    </div>
                </div>

                <div class="mt-2">
                    {{-- @dump($personal_services) --}}
                    @forelse ($personal_services as $cost_type =>

                    $personal_service)

                        <div class="ml-4 mb-2">
                            <p class="cost-type">
                                {{ $cost_type }}
                            </p>
                            <div class="ml-4">
                                @foreach ($personal_service as $indirect_cost_type => $groups)
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-700">
                                            {{ $indirect_cost_type }}
                                        </p>

                                        @foreach ($groups as $group_title => $expense)
                                            <div class="expense-label">
                                                <div class="ml-4 mr-6 flex justify-between text-gray-600 w-full">
                                                    <p class="italic text-xs text-gray-500">
                                                        {{ $expense->displaySelectedPS() }}
                                                    </p>
                                                    <p class="text-xs">
                                                        {{ number_format($expense->amount) }}
                                                    </p>
                                                </div>
                                                <div class="mb-2 flex ">
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
                @if ($record->getActualTotalPS() > 0)
                    <x-sub-total-lib label="Sub-total for PS" class="mt-1 rounded" :value="number_format($record->getActualTotalPS())" />
                @endif

            </div>
            <div class="mt-6">
                <div class="flex items-center border-b rounded pb-3">
                    <p class="text-primary-600 text-xl font-medium mr-4">II. Maintenance and Other Operating Expenses
                    </p>
                    <div class="mt-1">
                        {{ $this->addMOOEAction }}
                    </div>
                </div>


                <div class="mt-3">
                    {{-- @dump($mooes) --}}
                    @forelse ($mooes as $cost_type => $mooe)
                        <div class="ml-4  mb-2">
                            <p class="cost-type">

                                {{ $cost_type }}
                            </p>
                            <div class="ml-4">

                                @foreach ($mooe as $group_title => $groups)
                                    <div class="ml-4">
                                        <p class="font-medium text-gray-700 text-sm">
                                            {{ $group_title }}

                                        </p>

                                        @foreach ($groups as $key => $expense)
                                            <div class="expense-label">

                                                <div class="ml-4 mr-6 flex justify-between  text-gray-600 w-full    ">
                                                    <p class="italic  text-gray-500 text-xs">
                                                        {{ $expense->m_o_o_e_expense->title }}

                                                    </p>
                                                    <p class="text-xs">
                                                        {{ number_format($expense->amount) }}
                                                    </p>

                                                </div>

                                                <div class="mb-2 flex items-center justify-center">
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
                @if ($record->getActualTotalMOOE() > 0)
                    <x-sub-total-lib label="Sub-total for MOOE" class="mt-1 rounded" :value="number_format($record->getActualTotalMOOE())" />
                @endif



            </div>
            <div class="mt-6">
                <div class="flex items-center border-b rounded pb-3">
                    <p class="text-primary-600 text-xl font-medium mr-4">III Capital Outlay</p>
                    <div class="mt-1">
                        {{ $this->addCOAction }}
                    </div>
                </div>

                <div class="mt-2">
                    @forelse ($cos as $cost_type => $groups)
                        <div class="mt-4 mb-4 ml-4">
                            <p class="cost-type">

                                {{ $cost_type }}
                            </p>

                            @foreach ($groups as $key => $expense)
                                <div class="expense-label">

                                    <div class="ml-4 mr-6  flex   justify-between  text-gray-600 w-full    ">
                                        <p class="italic text-xs text-gray-500">
                                            ({{ $expense->quantity }})
                                            {{ $expense->description }} <span
                                                class="text-xs">({{ number_format($expense->amount) }} / Per
                                                item)</span>
                                        </p>
                                        <p class="text-xs">
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
                @if ($record->getActualTotalCO() > 0)
                    <x-sub-total-lib label="Sub-total for CO" class="mt-1 rounded" :value="number_format($record->getActualTotalCO())" />
                @endif


            </div>

        </div>
        @if ($record->getYearActualBudget() > 0)
            <div
                class="v3-d-gradient py-3 px-4 text-white grid-cols-12 text-xl font-bold flex justify-between items-center">

                <div>
                    <h1> {{ $record->year->title }} </h1>
                </div>
                <div class="flex items-center justify-center">
                    <div>
                        <h1> {{ number_format($record->getYearActualBudget()) }}</h1>
                    </div>
                    <div class="w-[80px]"> </div>
                </div>

            </div>
        @endif
    </div>

    <div class="col-span-3 p-4 ml-4 rounded bg-white">
        <h2 class="text-2xl font-bold tracking-tight text-gray-700 sm:text-2xl">LIB STATUS</h2>
        <div class="mt-4">
            <p class="p-2 rounded-lg v3-lib-status text-white text-center uppercase font-bold">{{$record->status}}</p>
            <div class="grid grid-cols-1 mt-4">
                {{-- Check if status is for editing --}}
                {{-- @if ($record->status == App\Models\ProjectYear::STATUS_FOR_EDITING) --}}
                {{$this->forReviewAction}}
                {{-- @elseif($record->status == App\Models\ProjectYear::STATUS_FOR_REVIEW) --}}

                {{-- Check if status is for review --}}
                {{-- @endif --}}
            </div>
            {{-- Action to cancel review --}}
            <div class="grid grid-cols-1">
                {{$this->cancelReview}}
            </div>
            {{-- Action to deny approval --}}
            <div class="grid grid-cols-1">
                {{$this->denyApprovalAction}}
            </div>
            {{-- Action to return to editing --}}
            <div class="grid grid-cols-1">
                {{$this->returnToEditingAction}}
            </div>
        </div>

        <div class="relative mt-6 ">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
              <div class="w-full border-t "></div>
            </div>
            <div class="relative flex justify-center text-sm font-medium leading-6">
              <span class="bg-white px-6 text-gray-900 poppins-regular tg6">Messages</span>
            </div>
          </div>

          <div class="flex items-center mt-4">
            <img src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80" alt="Emily Selman." class="h-12 w-12 rounded-full">
            <div class="ml-4">
              <h4 class="text-sm font-bold text-gray-900">Emily Selman</h4>
              <div class="mt-1 flex items-center">
                <p class="text-sm text-gray-500">example@gmail.com</p>
              </div>
              <p class="sr-only">5 out of 5 stars</p>
            </div>
          </div>
        <div class="mt-4 space-y-6  text-gray-700 text-xs">
            <p>I was really pleased with the overall shopping experience. My order even included a little personal, handwritten note, which delighted me!</p>
            <p>The product quality is amazing, it looks and feel even better than I had anticipated. Brilliant stuff! I would gladly recommend this store to my friends. And, now that I think of it... I actually have, many times!</p>
          </div>


    </div>

</div>

    <x-filament-actions::modals />


</div>
