<div class="bg-white rounded-lg px-12 py-8">








    <style>
        .h::before {
            content: ":";
            padding: 0px 10px;
            font-weight: bold;
        }

        .h {
            position: relative;
            padding: 0px 6px;
        }
    </style>
    {{-- {{$record}} --}}

    <x-back-button :url="route('project.line-item-budget', ['record' => $record->project_id])">Back</x-back-button>
    <div class="">
        <div class="text-gray-700 flex items-start justify-center">
            <div class="flex items-center px-4 mt-6   justify-end">
                <img src="{{ asset('images/dost.png') }}" alt="" class="h-12 w-12">
            </div>
            <div class="text-center uppercase text-gray-700">
                <p class="text-md">Dost Form 4</p>
                <p class="uppercase text-3xl leading-relaxed font-medium ">Department OF SCIENCE AND TECHNOLOGY</p>
                <p class="uppercase  text-md leading-none mt-1 ">Project Line Item Budget</p>
                <p class="mt-12 uppercase font-bold  text-center text-3xl mb-6 ">{{ $record->year->title }} </p>
            </div>
            <div class="flex items-center px-4 mt-6    justify-start ">
                <img src="{{ asset('images/sksu.png') }}" alt="" class="h-12 w-12">

            </div>
        </div>




        <x-title-with-b-g title="Project Information" class="title-bg mt-2 py-2" />

        <div class="p-2 border-b border-l  border-r cb py-2">
            <x-text description="Project Name" :text="$record->project->title" />
        </div>
        <div class="border-b grid grid-cols-2  border-l cb ">
            <div class="border-r p-2 ">
                <x-text description="Implementing Agency" :text="$record->project->implementing_agency" />
            </div>
            <div class="p-2 border-r">
                <x-text description="Monitoring Agency" :text="$record->project->monitoring_agency" />
            </div>
        </div>

        <div class="p-2 border-b border-l border-r cb py-2">
            <x-text description="Total Duration" :text="$total_months . ' months'" />
        </div>
        <div class="p-2 border-b border-l border-r cb py-2">
            <x-text description="Project Leader" :text="$record->project->project_leader" />
        </div>


        {{-- <x-title-with-b-g title="Line Item Budget Details" class="title-bg py-2 mt-2" /> --}}


        <div x-cloak id="accordion-flush" data-accordion="collapse"
            data-active-classes="  bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
            data-inactive-classes="text-gray-500 dark:text-gray-400">
            <div x-data="{ open: true }">
                <h2 id="accordion-flush-heading-1">
                    <button x-on:click="open = ! open" type="button"
                        class="border-r border-l pl-2  grid grid-cols-12  w-full  hover:bg-gray-100 transition rtl:text-right text-gray-600 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 "
                        data-accordion-target="#accordion-flush-body-1" aria-expanded="true"
                        aria-controls="accordion-flush-body-1">

                        <div class="col-span-9 flex items-center justify-between h-full px-2 ">
                            <div class="flex items-center ">
                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0 mr-4" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 5 5 1 1 5" />
                            </svg>
                            <p> I. Personal Service </p>

                            </div>
                            {{($this->redirectToPrintParticularPage)(['record' => $record, 'type' => 'ps'])}}

                        </div>

                        <div class="col-span-3   uppercase   border-l text-sm grid grid-cols-1 p-2">

                            <div class=" font-medium   flex items-center justify-between  ">
                                <div class="  flex justify-center items-center">
                                    Budget

                                </div>
                                <div class=" flex justify-center items-center">
                                    ₱ {{ number_format($record->getActualTotalPS()) }}
                                </div>

                            </div>
                        </div>
                    </button>
                </h2>
                <div id="accordion-flush-body-1" x-show="open" aria-labelledby="accordion-flush-heading-1">
                    <div class="text-gray-600">

                        {{-- <div class="grid grid-cols-12">
                            <div class="col-span-12 grid grid-cols-12 border-l border-b ">
                                <div
                                    class="col-span-10 flex items-center font-medium uppercase p-2 text-md text-center">
                                    I. Personal Service</div>

                                <div class="uppercase col-span-2 border-l text-sm grid grid-cols-1">

                                    <div class="border-r  font-medium   flex items-center justify-between p-2 ">
                                        <div class="  flex justify-center items-center">
                                            Budget

                                        </div>
                                        <div class="   flex justify-center items-center">

                                            ₱ {{ number_format($total_ps) }}
                                        </div>

                                    </div>
                                </div>

                            </div> --}}


                        <div class="col-span-12 text-xs">

                            @forelse ($personal_services as $cost_type => $personal_service)
                                <div class=" border-l    ">
                                    <div class="{{ $loop->first ? 'border-b' : '' }} {{ $loop->last ? '' : '' }}   ">
                                        <div class="grid grid-cols-12 {{ $loop->last ? '' : ' border-b' }}  ">
                                            <div class="col-span-12  light-bg  text-white   py-1 px-2">
                                                {{ $cost_type }}

                                            </div>
                                            <div class="col-span-12 grid grid-cols-12 ">
                                                @foreach ($personal_service as $group_title => $groups)
                                                <div class="col-span-12">

                                                </div>
                                                <div
                                                        class="col-span-12  grid grid-cols-12  transition  {{ $loop->last ? '' : 'border-b' }}">
                                                        <div class="col-span-2  p-4 flex items-center   border-r  ">
                                                            {{ $group_title }}
                                                            <x-filament-actions::group :actions="[
                                                                //   ($this->downloadBreakDown)(['record' => $expense->id, 'type' => 'ps']),
                                                                ($this->printGroup)(['record' => $groups[0]->p_s_group_id, 'type' => 'ps','year'=>$groups[0]->project_year_id])
                                                                ]"

                                                                  color="gray"
                                                                  size="xs"
                                                                  tooltip="More actions"

                                                                />


                                                        </div>
                                                        <div class="col-span-10  grid grid-cols-12  ">
                                                            @foreach ($groups as $key => $expense)
                                                            <div class="col-span-10">


                                                            </div>
                                                                <div
                                                                    class=" col-span-10  flex items-center  border-b   px-2 py-1   ">
                                                                    <span class="mr-2">
                                                                        ({{$expense->number_of_positions}})  {{ $expense->p_s_expense->title }} at {{ number_format($expense->p_s_expense->amount)}} x  {{$expense->duration}}/month(s)


                                                                    </span>
                                                                    {{ ($this->addPSBreakDown)(['record' => $expense->id]) }}
                                                                    @if ($expense->breakdowns->count())
                                                                        <x-filament-actions::group :actions="[
                                                                        //   ($this->downloadBreakDown)(['record' => $expense->id, 'type' => 'ps']),
                                                                          ($this->redirectToPrintPage)(['record' => $expense->id, 'type' => 'ps']),
                                                                        ]"

                                                                          color="gray"
                                                                          size="xs"
                                                                          tooltip="More actions"

                                                                        />


                                                                    @endif

                                                                </div>

                                                                <div
                                                                    class=" col-span-2  border-r   border-b text-xs font-medium">
                                                                    <div
                                                                        class="p-2 flex items-center font-medium justify-end">
                                                                        ₱
                                                                        {{ number_format($expense->amount) ?? 0 }}
                                                                    </div>
                                                                    {{-- <div class="border-r ">
                                                                            <div class="p-2  border-b flex items-center justify-center">
                                                                                Remaining
                                                                            </div>
                                                                            <div class="p-2 flex items-center justify-center">
                                                                                {{ number_format($expense->p_s_expense->amount) ?? 0 }}
                                                                            </div>
                                                                        </div> --}}
                                                                </div>


                                                                @foreach ($expense->breakdowns as $bk => $breakdown)
                                                                    <div
                                                                        class=" col-span-12 border-b grid grid-cols-12    ">
                                                                        <div
                                                                            class=" col-span-2   px-2 flex items-center justify-start">
                                                                            <div>

                                                                                {{ ($this->editBreakDownAction)(['record' => $breakdown->id]) }}
                                                                            </div>
                                                                            <div>
                                                                                {{ ($this->deleteBreakDown)(['record' => $breakdown->id]) }}

                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class=" col-span-3 text-gray-400  flex items-center px-2">
                                                                            {{ $breakdown->description }}
                                                                        </div>
                                                                        <div
                                                                            class="col-span-2   flex items-center justify-center ">
                                                                            {{ ($this->viewAttachment)(['record' => $breakdown->id]) }}
                                                                        </div>
                                                                        <div class=" col-span-3  grid grid-cols-1 ">
                                                                            <div
                                                                                class="px-2 flex items-center justify-end text-gray-600  border-l border-r">
                                                                                ₱
                                                                                {{ number_format($breakdown->amount ?? 0) }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-span-2  border-r"></div>



                                                                    </div>
                                                                @endforeach
                                                                {{-- <div class=" col-span-12 p-[0.5px] {{$loop->last ? '' :'light-bg' }} "></div> --}}
                                                                <div
                                                                class=" col-span-12 grid grid-cols-12 border-r border-b  bg-gray bg-gray-50 text-gray-400">
                                                                <div class="p-1  py-1 col-span-2    ">
                                                                       
                                                                        Total
                                                                    </div>
                                                                    <div class="p-1 col-span-3 "></div>
                                                                    <div class="p-1 col-span-2"> </div>
                                                                    <div
                                                                        class="px-2 py-1 col-span-3  border-l  text-right  text-gray-600 ">
                                                                        {{-- @if (($expense->breakdowns->sum('amount') ?? 0) > 0) --}}
                                                                        ₱
                                                                        {{ number_format($expense->totalSpent() ?? 0) }}
                                                                        {{-- @endif --}}

                                                                    </div>
                                                                    <div class=" col-span-2 border-l border-r ">

                                                                    </div>
                                                                </div>



                                                                {{-- <div class=" col-span-12 p-[0.5px] {{$loop->last ? '' :'light-bg' }} "></div> --}}
                                                                <div
                                                                    class=" col-span-12 grid grid-cols-12 border-r   bg-gray bg-gray-50 text-gray-600">
                                                                    <div class="p-1 col-span-2  ">
                                                                        Remaining

                                                                    </div>
                                                                    <div class="p-1 col-span-3 "> </div>
                                                                    <div class="p-1 col-span-2"> </div>
                                                                    <div
                                                                        class="px-2 py-1 col-span-3  border-l  text-left  ">
                                                                        ₱
                                                                        {{ number_format($expense->remainingBudget()) ?? 0 }}
                                                                    </div>
                                                                    <div class=" col-span-2 border-l border-r ">

                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class=" col-span-12 p-[0.5px] light-bg{{ $loop->last ? '' : '' }} ">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            @endforeach
                        </div>


                        <div
                            class="col-span-12  grid grid-cols-12 text-xs font-medium transition border-t  d-gradient  text-white      uppercase">

                            <div class="col-span-2  p-4 flex items-center   ">
                                PS Summary
                            </div>
                            <div class="col-span-10  grid grid-cols-12 border-b  ">

                                <div class=" col-span-12 grid grid-cols-12 ">
                                    <div class="p-2 flex items-center col-span-2   ">
                                    </div>
                                    <div class="p-2 flex items-center col-span-3 ">
                                        Used {{ intval($record->getPSTotalUsePercentage()) . '%' }}</div>
                                    <div class="p-2 text-left col-span-2"> </div>
                                    <div class="p-2 col-span-3 border-l border-r ">
                                        <div class="flex items-center justify-between">

                                            <p class="text-left">
                                                
                                                ₱ {{ number_format($record->getPSTotalRemainingBudget() ?? 0) }}

                                            </p>
                                            <p class="text-right">
                                                ₱ {{ number_format($record->getYearTotalPsBreakDown() ?? 0) }}

                                            </p>
                                        </div>
                                        <div class="flex items-center justify-between ">

                                            <p class="text-left">
                                                Remaining

                                            </p>
                                            <p class="text-right">
                                                Total Spent

                                            </p>
                                        </div>

                                    </div>


                                    <div class="p-2  col-span-2 text-right border-r border-gray-400 ">
                                        <p>
                                            ₱ {{ number_format($record->getActualTotalPS() ?? 0) }}

                                        </p>
                                        <p class="text-right">
                                            TOTAL

                                        </p>

                                    </div>
                                </div>
                                <div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div x-data="{ open: true }">
                <h2 id="accordion-flush-heading-2">
                    <button x-on:click="open = ! open" type="button"
                        class="border-r border-l pl-2  grid grid-cols-12  w-full  hover:bg-gray-100 transition rtl:text-right text-gray-600 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 "
                        data-accordion-target="#accordion-flush-body-1" aria-expanded="true"
                        aria-controls="accordion-flush-body-1">


                        <div class="col-span-9 flex items-center justify-between h-full px-2 ">
                            <div class="flex items-center ">
                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0 mr-4" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 5 5 1 1 5" />
                            </svg>
                            <p> II. Maintenance and Other Operating Expenses </p>

                            </div>
                            {{($this->redirectToPrintParticularPage)(['record' => $record, 'type' => 'mooe'])}}

                        </div>

                        <div class="col-span-3   uppercase   border-l text-sm grid grid-cols-1 p-2">

                            <div class=" font-medium   flex items-center justify-between  ">
                                <div class="  flex justify-center items-center">
                                    Budget

                                </div>
                                <div class=" flex justify-center items-center">
                                    ₱ {{ number_format($record->getActualTotalMOOE()) }}
                                </div>

                            </div>
                        </div>
                    </button>

                </h2>
                <div id="accordion-flush-body-2" x-show="open" aria-labelledby="accordion-flush-heading-2">
                    <div class="text-gray-600">

                    

                        <div class="col-span-12 text-xs">

                            @forelse ($mooes as $cost_type => $mooe)
                                <div class=" border-l    ">
                                    <div class="{{ $loop->first ? 'border-b' : '' }} {{ $loop->last ? '' : '' }}   ">
                                        <div class="grid grid-cols-12   ">
                                            <div class="col-span-12  light-bg  text-white border-b py-1 px-2">
                                                {{ $cost_type }}

                                            </div>
                                            <div class="col-span-12 grid grid-cols-12 ">
                                                @foreach ($mooe as $group_title => $groups)
                                            <div class="col-span-12">
                                               
                                            </div>
                                                    <div
                                                        class="col-span-12  grid grid-cols-12  transition  {{ $loop->last ? '' : 'border-b' }}">
                                                        <div class="col-span-2  p-4 flex items-center   border-r  ">
                                                            {{ $group_title }}

                                                            <x-filament-actions::group :actions="[

                                                              
                                                                ($this->printGroup)(['record' => $groups[0]->m_o_o_e_group_id, 'type' => 'mooe','year'=>$groups[0]->project_year_id])
                                                                ]"

                                                                  color="gray"
                                                                  size="xs"
                                                                  tooltip="More actions"

                                                                />
                                                        </div>
                                                        <div class="col-span-10  grid grid-cols-12  ">
                                                            @foreach ($groups as $key => $expense)
                                                                <div
                                                                    class=" col-span-10  flex items-center  border-b px-2 py-1   ">
                                                                    <span class="mr-2">
                                                                        ({{$expense->specification}})  {{ $expense->m_o_o_e_expense->title }}


                                                                    </span>
                                                                    {{ ($this->addMOOEBreakDown)(['record' => $expense->id]) }}

                                                                    @if ($expense->breakdowns->count())
                                                                    <x-filament-actions::group :actions="[
                                                                 
                                                                      ($this->redirectToPrintPage)(['record' => $expense->id, 'type' => 'mooe']),
                                                                    ]"

                                                                      color="gray"
                                                                      size="xs"
                                                                      tooltip="More actions"

                                                                    />
                                                                @endif



                                                                </div>

                                                                <div
                                                                    class=" col-span-2  border-r  border-b text-xs font-medium">
                                                                    <div
                                                                        class="p-2 flex items-center font-medium justify-end">
                                                                        ₱
                                                                        <span class="mr-2">
                                                                            {{ number_format($expense->amount) ?? 0 }}
                                                                    </div>
                                                               
                                                                </div>


                                                                @foreach ($expense->breakdowns as $bk => $breakdown)
                                                                    <div
                                                                        class=" col-span-12 border-b grid grid-cols-12   ">
                                                                        <div
                                                                            class=" col-span-2   px-2 flex items-center justify-start">
                                                                            <div>

                                                                                {{ ($this->editBreakDownAction)(['record' => $breakdown->id]) }}
                                                                            </div>
                                                                            <div>
                                                                                {{ ($this->deleteBreakDown)(['record' => $breakdown->id]) }}

                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class=" col-span-3 text-gray-400  flex items-center px-2">
                                                                            {{ $breakdown->description }}
                                                                        </div>
                                                                        <div
                                                                            class="col-span-2   flex items-center justify-center ">
                                                                            {{ ($this->viewAttachment)(['record' => $breakdown->id]) }}
                                                                        </div>
                                                                        <div class=" col-span-3  grid grid-cols-1 ">
                                                                            <div
                                                                                class="px-2 flex items-center justify-end text-gray-600  border-l border-r">
                                                                                ₱
                                                                                {{ number_format($breakdown->amount ?? 0) }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-span-2  border-r">
                                                                        </div>



                                                                    </div>
                                                                @endforeach
                                                                {{-- <div class=" col-span-12 p-[0.5px] {{$loop->last ? '' :'light-bg' }} "></div> --}}
                                                                <div
                                                                    class=" col-span-12 grid grid-cols-12 border-r border-b  bg-gray bg-gray-50 text-gray-400">
                                                                    <div class="p-1  py-1 col-span-2   ">
                                                                        Total
                                                                    </div>
                                                                    <div class="p-1 col-span-3 "></div>
                                                                    <div class="p-1 col-span-2"> </div>
                                                                    <div
                                                                        class="px-2 py-1 col-span-3  border-l  text-right  text-gray-600 ">
                                                                        {{-- @if (($expense->breakdowns->sum('amount') ?? 0) > 0) --}}
                                                                        ₱
                                                                        {{ number_format($expense->totalSpent() ?? 0) }}
                                                                        {{-- @endif --}}

                                                                    </div>
                                                                    <div class=" col-span-2 border-l border-r ">

                                                                    </div>
                                                                </div>



                                                                {{-- <div class=" col-span-12 p-[0.5px] {{$loop->last ? '' :'light-bg' }} "></div> --}}
                                                                <div
                                                                    class=" col-span-12 grid grid-cols-12 border-r   bg-gray bg-gray-50 text-gray-600">
                                                                    <div class="p-1 col-span-2  ">
                                                                        Remaining

                                                                    </div>
                                                                    <div class="p-1 col-span-3 "> </div>
                                                                    <div class="p-1 col-span-2"> </div>
                                                                    <div
                                                                        class="px-2 py-1 col-span-3  border-l  text-left  ">
                                                                        ₱
                                                                        {{ number_format($expense->remainingBudget()) ?? 0 }}
                                                                    </div>
                                                                    <div class=" col-span-2 border-l border-r ">

                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class=" col-span-12 p-[0.5px] light-bg{{ $loop->last ? '' : '' }} ">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            @endforeach
                        </div>


                        <div
                            class="col-span-12  grid grid-cols-12 text-xs font-medium transition border-t  d-gradient  text-white      uppercase">
                            <div class="col-span-12 border-b p-2 flex items-center    ">
                                MOOE Summary
                            </div>
                            <div class="col-span-2  p-4 flex items-center   ">

                            </div>
                            <div class="col-span-10  grid grid-cols-12 border-b  ">

                                <div class=" col-span-12 grid grid-cols-12 ">
                                    <div class="p-2 flex items-center col-span-2   ">
                                    </div>
                                    <div class="p-2 flex items-center col-span-3 ">

                                        Used {{ intVal($record->getMOOETotalUsePercentage() ?? 0) . '%' }}</div>
                                    <div class="p-2 text-left col-span-2"> </div>
                                    <div class="p-2 col-span-3 border-l border-r">
                                        <div class="flex items-center justify-between">

                                            <p class="text-left">
                                                ₱ {{ number_format($record->getMOOETotalRemainingBudget() ?? 0) }}

                                            </p>
                                            <p class="text-right">
                                                ₱ {{ number_format($record->getYearTotalMOOEBreakDown() ?? 0) }}

                                            </p>
                                        </div>
                                        <div class="flex items-center justify-between">

                                            <p class="text-left">
                                                Remaining

                                            </p>
                                            <p class="text-right">
                                                Total Spent

                                            </p>
                                        </div>

                                    </div>


                                    <div class="px-2 py-1 col-span-2 text-right border-r border-gray-400 ">
                                        <p>
    
                                            ₱ {{ number_format($record->getActualTotalMOOE() ?? 0) }}

                                        </p>
                                        <p class="text-right">
                                            TOTAL

                                        </p>

                                    </div>
                                </div>
                                <div>
                                </div>



                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <div x-data="{ open: true }">
            <h2 id="accordion-flush-heading-3">
                <button x-on:click="open = ! open" type="button"
                    class="border-r border-l pl-2  grid grid-cols-12  w-full  hover:bg-gray-100 transition rtl:text-right text-gray-600 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 "
                    data-accordion-target="#accordion-flush-body-1" aria-expanded="true"
                    aria-controls="accordion-flush-body-1">



                    <div class="col-span-9 flex items-center justify-between h-full px-2 ">
                        <div class="flex items-center ">
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0 mr-4" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M9 5 5 1 1 5" />
                        </svg>
                        <p> III. Capital Outlay</p>

                        </div>
                        {{($this->redirectToPrintParticularPage)(['record' => $record, 'type' => 'co'])}}

                    </div>

                    <div class="col-span-3   uppercase   border-l text-sm grid grid-cols-1 p-2">

                        <div class=" font-medium   flex items-center justify-between  ">
                            <div class="  flex justify-center items-center">
                                Budget

                            </div>
                            <div class=" flex justify-center items-center">
                                ₱ {{ number_format($record->getActualTotalCO()) }}
                            </div>

                        </div>
                    </div>
                </button>

                </button>
            </h2>
            <div id="accordion-flush-body-3" x-show="open" aria-labelledby="accordion-flush-heading-3">
                <div class="text-gray-600">

                    <div class="grid grid-cols-12">
                        <div class="col-span-2 text-xs  p-4 flex items-center border-l justify-center   text-gray-600  ">
                            NO Category
                        </div>
                        <div class="col-span-10 text-xs">

                            @forelse ($cos as $cost_type => $co)
                                <div class=" border-l    ">
                                    <div class="{{ $loop->first ? 'border-b' : '' }} {{ $loop->last ? '' : '' }}   ">
                                        <div class="grid grid-cols-12 border-b  ">
                                            <div class="col-span-12  light-bg  text-white border-b py-1 px-2">
                                                {{ $cost_type }}

                                            </div>
                                            <div class="col-span-12  grid grid-cols-12  ">
                                                @foreach ($co as $key => $expense)
                                                    <div
                                                        class=" col-span-10  flex items-center  border-b px-2 py-1   ">
                                                        <span class="mr-2">
                                                            ({{$expense->quantity}}) {{ $expense->description }} <span class="text-xs">({{number_format($expense->amount)}}/Per item)</span>


                                                        </span>
                                                        {{ ($this->addCOBreakDown)(['record' => $expense->id]) }}
                                                        @if ($expense->breakdowns->count())
                                                        <x-filament-actions::group :actions="[
                                                          ($this->redirectToPrintPage)(['record' => $expense->id, 'type' => 'co']),
                                                        ]"

                                                          color="gray"
                                                          size="xs"
                                                          tooltip="More actions"

                                                        />
                                                    @endif


                                                    </div>

                                                    <div class=" col-span-2  border-r  border-b text-xs font-medium">
                                                        <div class="p-2 flex items-center font-medium justify-end">
                                                            ₱
                                                            <span class="mr-2">
                                                                {{ number_format($expense->new_amount) ?? 0 }}
                                                        </div>
                                                      
                                                    </div>


                                                    @foreach ($expense->breakdowns as $bk => $breakdown)
                                                        <div
                                                            class=" col-span-12 border-b grid grid-cols-12   transition ">
                                                            <div
                                                                class=" col-span-2   px-2 flex items-center justify-start">
                                                                <div>

                                                                    {{ ($this->editBreakDownAction)(['record' => $breakdown->id]) }}
                                                                </div>
                                                                <div>
                                                                    {{ ($this->deleteBreakDown)(['record' => $breakdown->id]) }}

                                                                </div>
                                                            </div>
                                                            <div
                                                                class=" col-span-3 text-gray-400  flex items-center px-2">
                                                                {{ $breakdown->description }}
                                                            </div>
                                                            <div
                                                                class="col-span-2   flex items-center justify-center ">
                                                                {{ ($this->viewAttachment)(['record' => $breakdown->id]) }}
                                                            </div>
                                                            <div class=" col-span-3  grid grid-cols-1 ">
                                                                <div
                                                                    class="px-2 flex items-center justify-end text-gray-600  border-l border-r">
                                                                    ₱
                                                                    {{ number_format($breakdown->amount ?? 0) }}
                                                                </div>
                                                            </div>
                                                            <div class="col-span-2  border-r"></div>



                                                        </div>
                                                    @endforeach
                                                    <div
                                                        class=" col-span-12 grid grid-cols-12 border-r border-b  bg-gray bg-gray-50 text-gray-400">
                                                        <div class="p-1  py-1 col-span-2   ">
                                                            Total
                                                        </div>
                                                        <div class="p-1 col-span-3 "></div>
                                                        <div class="p-1 col-span-2"> </div>
                                                        <div
                                                            class="px-2 py-1 col-span-3  border-l  text-right  text-gray-400 ">
                                                            ₱
                                                            {{ number_format($expense->totalSpent() ?? 0) }}

                                                        </div>
                                                        <div class=" col-span-2 border-l border-r ">

                                                        </div>
                                                    </div>



                                                    <div
                                                        class=" col-span-12 grid grid-cols-12 border-r   bg-gray bg-gray-50 text-gray-600">
                                                        <div class="p-1 col-span-2  ">
                                                            Remaining

                                                        </div>
                                                        <div class="p-1 col-span-3 "> </div>
                                                        <div class="p-1 col-span-2"> </div>
                                                        <div class="px-2 py-1 col-span-3  border-l  text-left  ">
                                                            ₱
                                                            {{ number_format($expense->remainingBudget()) ?? 0 }}
                                                        </div>
                                                        <div class=" col-span-2 border-l border-r ">

                                                        </div>
                                                    </div>
                                                    <div
                                                        class=" col-span-12 p-[0.5px] {{ $loop->last ? '' : 'light-bg' }} ">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            @endforeach
                        </div>


                  

                        <div
                        class="col-span-12  grid grid-cols-12 text-xs font-medium transition border-t  d-gradient  text-white      uppercase">
                        <div class="col-span-12 border-b p-2 flex items-center    ">
                            CO Summary
                        </div>
                        <div class="col-span-2  p-4 flex items-center   ">

                        </div>
                        <div class="col-span-10  grid grid-cols-12   ">

                            <div class=" col-span-12 grid grid-cols-12 ">
                                <div class="p-2 flex items-center col-span-2   ">
                                </div>
                                <div class="p-2 flex items-center col-span-3 ">

                                    Used {{ intVal($record->getCOTotalUsePercentage() ?? 0) . '%' }}</div>
                                <div class="p-2 text-left col-span-2"> </div>
                                <div class="p-2 col-span-3 border-l border-r">
                                    <div class="flex items-center justify-between">

                                        <p class="text-left">
                                            ₱ {{ number_format($record->getCOTotalRemainingBudget() ?? 0) }}

                                        </p>
                                        <p class="text-right">
                                            ₱ {{ number_format($record->getYearTotalCOBreakDown() ?? 0) }}

                                        </p>
                                    </div>
                                    <div class="flex items-center justify-between">

                                        <p class="text-left">
                                            Remaining

                                        </p>
                                        <p class="text-right">
                                            Total Spent

                                        </p>
                                    </div>

                                </div>


                                <div class="px-2 py-1 col-span-2 text-right border-r border-gray-400 ">
                                    <p>

                                        ₱ {{ number_format($record->getActualTotalCO() ?? 0) }}

                                    </p>
                                    <p class="text-right">
                                        TOTAL

                                    </p>

                                </div>
                            </div>
                            <div>
                            </div>



                        </div>
                    </div>

                    </div>
                </div>

            </div>

            <div
            class="col-span-12   grid grid-cols-12 text-md font-medium transition   bg-3  text-gray-200      uppercase">
          
            <div class="col-span-2  p-4 flex items-center   ">

            </div>
            <div class="col-span-10  grid grid-cols-12 ">

                <div class=" col-span-12 grid grid-cols-12 ">
                  
                    <div class="p-2 flex items-center col-span-5">
                        <div class="flex items-center w-full">
                            <span class="mr-2">Used</span>
                            <div class="relative w-full bg-gray-200 rounded-full h-2">
                                <div class="absolute left-0 top-0 bg-green-500 rounded-full h-2"
                                    style="width: {{ $record->getBudgetPercentageUse() }}%;"></div>
                            </div>
                            <span class="ml-2">{{ intVal($record->getBudgetPercentageUse()) }}%</span>
                        </div>
                    </div>
                    
                    
                    <div class="p-2 text-left col-span-2"> </div>
                    <div class="p-2 py-6 col-span-3 border-l border-r">
                        <div class="flex items-center justify-between">

                            <p class="text-left">
                                ₱ {{ number_format($record->getYearRemainingBudget() ?? 0) }}

                            </p>
                            <p class="text-right">
                                ₱ {{ number_format($record->getYearTotalSpent() ?? 0) }}

                            </p>
                        </div>
                        <div class="flex items-center justify-between">

                            <p class="text-left">
                                Remaining

                            </p>
                            <p class="text-right">
                                Total Spent

                            </p>
                        </div>

                    </div>


                    <div class="px-2 py-1 col-span-2 flex flex-col items-center justify-center">
                        <p class="text-right">
                            ₱ {{ number_format($record->getYearActualBudget() ?? 0) }}
                        </p>
                        <p class="text-center">
                            Total
                        </p>
                    </div>
                    
                </div>
                <div>
                </div>



            </div>
        </div>
            {{-- <div class="bg-2">
                <p class="text-white uppercase font-medium p-4 border-b">
                    {{ $record->year->title }} Summary Details
                </p>
                <div class="  pl-2  text-white  grid grid-cols-12  w-full   transition rtl:text-right  border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 "
                    data-accordion-target="#accordion-flush-body-1" aria-expanded="true"
                    aria-controls="accordion-flush-body-1">

                    <div class="col-span-9 grid grid-cols-12 p-3">
                        <div class="col-span-4  text-center h-full justify-center flex items-center">
                            <div class="uppercase mr-2 text-xs">
                                USED

                            </div>
                            <div class="flex items-center w-full">
                                <div class="relative w-full bg-gray-200 rounded-full h-2">
                                    <div class="absolute left-0 top-0 bg-green-500 rounded-full h-2"
                                        style="width: {{ $record->getBudgetPercentageUse() }}%;"></div>
                                </div>
                                <span class="ml-2">{{ intVal($record->getBudgetPercentageUse()) }}%</span>
                            </div>
                        </div>

                        <div class="col-span-4   text-center h-full   grid grid-cols-1 ">
                            <div>
                                ₱ {{ number_format($record->getYearRemainingBudget()) }}

                            </div>
                            <div>
                                Remaining

                            </div>
                        </div>
                        <div class="col-span-4   text-center h-full   grid grid-cols-1 ">
                            <div>
                                ₱ {{ number_format($record->getYearTotalSpent()) }}

                            </div>
                            <div>
                                Total Spent

                            </div>
                        </div>
                    </div>

                    <div class="col-span-3     border-l  grid grid-cols-1 p-2" >

                        <div class=" font-medium   flex items-center justify-between  ">
                            <div class="  flex justify-center items-center ">
                                Total Budget

                            </div>
                            <div class=" flex justify-center items-center">
                                ₱ {{ number_format($record->getYearActualBudget()) }}
                            </div>

                        </div>

                    </div>
                    </button>
                </div>
            </div> --}}


            <x-filament-actions::modals />

        </div>
