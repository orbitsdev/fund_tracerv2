<div class="bg-white rounded-lg shadow-md p-4">








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
    <div>
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
            <div x-data="{ open: false }">
                <h2 id="accordion-flush-heading-1">
                    <button x-on:click="open = ! open" type="button"
                        class="border-r border-l pl-2  grid grid-cols-12  w-full  hover:bg-gray-50 transition rtl:text-right text-gray-600 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 "
                        data-accordion-target="#accordion-flush-body-1" aria-expanded="true"
                        aria-controls="accordion-flush-body-1">

                        <div class="col-span-9 flex items-center h-full  p-2 ">
                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0 mr-4" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 5 5 1 1 5" />
                            </svg>
                            <p> I. Personal Service </p>

                        </div>

                        <div class="col-span-3   uppercase   border-l text-sm grid grid-cols-1 p-2">

                            <div class=" font-medium   flex items-center justify-between  ">
                                <div class="  flex justify-center items-center">
                                    Allocated Budget

                                </div>
                                <div class=" flex justify-center items-center">
                                    ₱ {{ number_format($total_ps) }}
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
                                            Allocated Budget

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
                                        <div class="grid grid-cols-12 border-b  ">
                                            <div class="col-span-12  light-bg  text-white border-b py-1 px-2">
                                                {{ $cost_type }}

                                            </div>
                                            <div class="col-span-12 grid grid-cols-12 ">
                                                @foreach ($personal_service as $group_title => $groups)
                                                    <div
                                                        class="col-span-12  grid grid-cols-12  transition  {{ $loop->last ? '' : 'border-b' }}">
                                                        <div class="col-span-2  p-4 flex items-center   border-r  ">
                                                            {{ $group_title }}
                                                        </div>
                                                        <div class="col-span-10  grid grid-cols-12  ">
                                                            @foreach ($groups as $key => $expense)
                                                                <div
                                                                    class=" col-span-10  flex items-center  border-b px-2 py-1 border  ">
                                                                    <span class="mr-2">
                                                                        {{ $expense->p_s_expense->title }}


                                                                    </span>
                                                                    {{ ($this->addPSBreakDown)(['record' => $expense->id]) }}

                                                                </div>

                                                                <div
                                                                    class=" col-span-2  border-r  border-b text-xs font-medium">
                                                                    <div
                                                                        class="p-2 flex items-center font-medium justify-end">
                                                                        ₱
                                                                        {{ number_format($expense->p_s_expense->amount) ?? 0 }}
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
                                                                        <div class="col-span-2  border-r"></div>



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
                                                                        class="p-1 col-span-3  border-l  text-right  text-gray-600 ">
                                                                        {{-- @if (($expense->breakdowns->sum('amount') ?? 0) > 0) --}}
                                                                        ₱
                                                                        {{ number_format($expense->breakdowns->sum('amount') ?? 0) }}
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
                                                                        class="p-1  col-span-3  border-l border-r text-left ">
                                                                        ₱
                                                                        {{ number_format($expense->p_s_expense->amount - $expense->breakdowns->sum('amount')) ?? 0 }}
                                                                    </div>
                                                                    <div class="col-span-2  "></div>
                                                                </div>
                                                                <div
                                                                    class=" col-span-12 p-[0.5px] {{ $loop->last ? '' : 'light-bg' }} ">
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

                                        Budget Used {{ number_format($percentage_used_ps ?? 0) . '%' }}</div>
                                    <div class="p-2 text-left col-span-2"> </div>
                                    <div class="p-2 col-span-3 border-l ">
                                        <div class="flex items-center justify-between">

                                            <p class="text-left">
                                                ₱ {{ number_format($remaining_budget_ps ?? 0) }}

                                            </p>
                                            <p class="text-right">
                                                ₱ {{ number_format($total_ps_breakdown ?? 0) }}

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


                                    <div class="p-2  col-span-2 text-right border-r border-gray-400 ">
                                        <p>
                                            ₱ {{ number_format($total_ps ?? 0) }}

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

            <div x-data="{ open: false }">
                <h2 id="accordion-flush-heading-2">
                    <button x-on:click="open = ! open" type="button"
                        class="border-r border-l pl-2  grid grid-cols-12  w-full  hover:bg-gray-50 transition rtl:text-right text-gray-600 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 "
                        data-accordion-target="#accordion-flush-body-1" aria-expanded="true"
                        aria-controls="accordion-flush-body-1">

                        <div class="col-span-9 flex items-center h-full  p-2 ">
                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0 mr-4" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 5 5 1 1 5" />
                            </svg>
                            <p> II. Maintenance and Other Operating Expenses </p>

                        </div>

                        <div class="col-span-3   uppercase   border-l text-sm grid grid-cols-1 p-2">

                            <div class=" font-medium   flex items-center justify-between  ">
                                <div class="  flex justify-center items-center">
                                    Allocated Budget

                                </div>
                                <div class=" flex justify-center items-center">
                                    ₱ {{ number_format($total_mooe) }}
                                </div>

                            </div>
                        </div>
                    </button>

                </h2>
                <div id="accordion-flush-body-2" x-show="open" aria-labelledby="accordion-flush-heading-2">
                    <div class="text-gray-600">

                        {{-- <div class="grid grid-cols-12">
                                <div class="col-span-12 grid grid-cols-12 border-l border-b ">
                                    <div
                                        class="col-span-10 flex items-center font-medium uppercase p-2 text-md text-center">
                                        II. Maintenance and Other Operating Expenses</div>

                                    <div class="uppercase col-span-2 border-l text-sm grid grid-cols-1">

                                        <div class="border-r  font-medium   flex items-center justify-between p-2 ">
                                            <div class="  flex justify-center items-center">
                                                Allocated Budget

                                            </div>
                                            <div class="   flex justify-center items-center">

                                                ₱ {{ number_format($total_mooe ?? 0) }}
                                            </div>

                                        </div>
                                    </div>

                                </div> --}}

                        <div class="col-span-12 text-xs">

                            @forelse ($mooes as $cost_type => $mooe)
                                <div class=" border-l    ">
                                    <div class="{{ $loop->first ? 'border-b' : '' }} {{ $loop->last ? '' : '' }}   ">
                                        <div class="grid grid-cols-12 border-b  ">
                                            <div class="col-span-12  light-bg  text-white border-b py-1 px-2">
                                                {{ $cost_type }}

                                            </div>
                                            <div class="col-span-12 grid grid-cols-12 ">
                                                @foreach ($mooe as $group_title => $groups)
                                                    <div
                                                        class="col-span-12  grid grid-cols-12  transition  {{ $loop->last ? '' : 'border-b' }}">
                                                        <div class="col-span-2  p-4 flex items-center   border-r  ">
                                                            {{ $group_title }}
                                                        </div>
                                                        <div class="col-span-10  grid grid-cols-12  ">
                                                            @foreach ($groups as $key => $expense)
                                                                <div
                                                                    class=" col-span-10  flex items-center  border-b px-2 py-1 border  ">
                                                                    <span class="mr-2">
                                                                        {{ $expense->m_o_o_e_expense->title }}


                                                                    </span>
                                                                    {{ ($this->addMOOEBreakDown)(['record' => $expense->id]) }}

                                                                </div>

                                                                <div
                                                                    class=" col-span-2  border-r  border-b text-xs font-medium">
                                                                    <div
                                                                        class="p-2 flex items-center font-medium justify-end">
                                                                        ₱
                                                                        <span class="mr-2">
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
                                                                        class="p-1 col-span-3  border-l  text-right  text-gray-600 ">
                                                                        {{-- @if (($expense->breakdowns->sum('amount') ?? 0) > 0) --}}
                                                                        ₱
                                                                        {{ number_format($expense->breakdowns->sum('amount') ?? 0) }}
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
                                                                        class="p-1  col-span-3  border-l border-r text-left ">
                                                                        ₱
                                                                        {{ number_format($expense->amount - $expense->breakdowns->sum('amount')) ?? 0 }}
                                                                    </div>
                                                                    <div class="col-span-2  "></div>
                                                                </div>
                                                                <div
                                                                    class=" col-span-12 p-[0.5px] {{ $loop->last ? '' : 'light-bg' }} ">
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

                                        Budget Used {{ number_format($percentage_used_mooe ?? 0) . '%' }}</div>
                                    <div class="p-2 text-left col-span-2"> </div>
                                    <div class="p-2 col-span-3 border-l ">
                                        <div class="flex items-center justify-between">

                                            <p class="text-left">
                                                ₱ {{ number_format($remaining_budget_mooe ?? 0) }}

                                            </p>
                                            <p class="text-right">
                                                ₱ {{ number_format($total_mooe_breakdown ?? 0) }}

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


                                    <div class="p-2  col-span-2 text-right border-r border-gray-400 ">
                                        <p>
                                            ₱ {{ number_format($total_mooe ?? 0) }}

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
        <div x-data="{ open: false }">
            <h2 id="accordion-flush-heading-3">
                <button x-on:click="open = ! open" type="button"
                class="border-r border-l pl-2  grid grid-cols-12  w-full  hover:bg-gray-50 transition rtl:text-right text-gray-600 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 "
                data-accordion-target="#accordion-flush-body-1" aria-expanded="true"
                aria-controls="accordion-flush-body-1">

                <div class="col-span-9 flex items-center h-full  p-2 ">
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0 mr-4" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M9 5 5 1 1 5" />
                    </svg>
                    <p>   III. Capital Outlay</p>

                </div>

                <div class="col-span-3   uppercase   border-l text-sm grid grid-cols-1 p-2">

                    <div class=" font-medium   flex items-center justify-between  ">
                        <div class="  flex justify-center items-center">
                            Allocated Budget

                        </div>
                        <div class=" flex justify-center items-center">
                            ₱ {{ number_format($total_co) }}
                        </div>

                    </div>
                </div>
            </button>

                </button>
            </h2>
            <div id="accordion-flush-body-3" x-show="open" aria-labelledby="accordion-flush-heading-3">
                <div class="text-gray-600">

                    <div class="grid grid-cols-12">
                        {{-- <div class="col-span-12 grid grid-cols-12 border-l border-b ">
                            <div class="col-span-10 flex items-center font-medium uppercase p-2 text-md text-center">
                                III. Capital Outlay</div>

                            <div class="uppercase col-span-2 border-l text-sm grid grid-cols-1">

                                <div class="border-r  font-medium   flex items-center justify-between p-2 ">
                                    <div class="  flex justify-center items-center">
                                        Allocated Budget

                                    </div>
                                    <div class="   flex justify-center items-center">

                                        ₱ {{ number_format($total_co ?? 0) }}
                                    </div>

                                </div>
                            </div>

                        </div> --}}

                        <div class="col-span-12 text-xs">

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
                                                        class=" col-span-10  flex items-center  border-b px-2 py-1 border  ">
                                                        <span class="mr-2">
                                                            {{ $expense->description }}


                                                        </span>
                                                        {{ ($this->addCOBreakDown)(['record' => $expense->id]) }}

                                                    </div>

                                                    <div class=" col-span-2  border-r  border-b text-xs font-medium">
                                                        <div class="p-2 flex items-center font-medium justify-end">
                                                            ₱
                                                            <span class="mr-2">
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
                                                        <div class=" col-span-12 border-b grid grid-cols-12   ">
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
                                                        <div class="p-1  py-1 col-span-2   ">
                                                            Total
                                                        </div>
                                                        <div class="p-1 col-span-3 "></div>
                                                        <div class="p-1 col-span-2"> </div>
                                                        <div
                                                            class="p-1 col-span-3  border-l  text-right  text-gray-400 ">
                                                            {{-- @if (($expense->breakdowns->sum('amount') ?? 0) > 0) --}}
                                                            ₱
                                                            {{ number_format($expense->breakdowns->sum('amount') ?? 0) }}
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
                                                        <div class="p-1  col-span-3  border-l border-r text-left ">
                                                            ₱
                                                            {{ number_format($expense->amount - $expense->breakdowns->sum('amount')) ?? 0 }}
                                                        </div>
                                                        <div class="col-span-2  "></div>
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

                            <div class="col-span-2  p-4 flex items-center   ">
                                CO Summary
                            </div>
                            <div class="col-span-12  grid grid-cols-12 border-b  ">

                                <div class=" col-span-12 grid grid-cols-12 ">
                                    <div class="p-2 flex items-center col-span-2   ">
                                    </div>
                                    <div class="p-2 flex items-center col-span-3 ">

                                        Budget Used {{ number_format($percentage_used_co ?? 0) . '%' }}</div>
                                    <div class="p-2 text-left col-span-2"> </div>
                                    <div class="p-2 col-span-3 border-l ">
                                        <div class="flex items-center justify-between">

                                            <p class="text-left">
                                                ₱ {{ number_format($remaining_budget_co ?? 0) }}

                                            </p>
                                            <p class="text-right">
                                                ₱ {{ number_format($total_co_breakdown ?? 0) }}

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


                                    <div class="p-2  col-span-2 text-right border-r border-gray-400 ">
                                        <p>
                                            ₱ {{ number_format($total_co ?? 0) }}

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


        {{-- <div class="">
            <h1 class="text-xl font-medium mb-2">{{ $record->year->title }} Budget and Expenses Breakdown</h1>
            <p class=" mb-4 text-xs text-gray-600">This document provides a detailed breakdown of the budget allocation
                for
                the {{ $record->year->title }} project, outlining various line items and expenses. It serves as a
                comprehensive financial plan to track and manage expenses throughout the project lifecycle.</p>

            <div class="border-t border-gray-200 ">
                <div class="flex items-center justify-between px-2 pt-4 mt-2 bg-[#0e343dfa] text-white">
                    <h2 class="text-md font-semibold mb-2 ">I. Personal Service</h2>
                    <h2 class="text-md font-semibold mb-2 ">{{ number_format($total_budget) }}</h2>
                </div>
                <div>
                    @forelse ($personal_services as $cost_type => $personal_service)
                        <div class="mb-4">
                            <p class="text-gray-800 text-xs font-semibold">{{ $cost_type }}</p>
                            <div class="ml-2">
                                @foreach ($personal_service as $group_title => $groups)
                                    <div class="mb-2">
                                        <p class="text-gray-700  text-xs  font-semibold">{{ $group_title }}</p>
                                        @foreach ($groups as $key => $expense)
                                            <div class="">

                                                <div
                                                    class=" mt-1 rounded-sm  px-6 ml-4 flex justify-between items-center  text-white  ">
                                                    <div class=" flex items-center ">
                                                        <p class=" text-xs italic mr-4">
                                                            {{ $expense->p_s_expense->title }}</p>
                                                        <div class="flex items-center space-x-2">
                                                            {{ ($this->addPSBreakDown)(['record' => $expense->id]) }}

                                                        </div>
                                                    </div>
                                                    <div class=" font-medium">
                                                        {{ number_format($expense->p_s_expense->amount) ?? 0 }}
                                                    </div>
                                                </div>
                                                @foreach ($expense->breakdowns as $bk => $breakdown)
                                                    <div
                                                        class="{{ $loop->first ? '' : '' }} {{ $loop->last ? 'border-b' : '' }} border-t  ml-12   text-sm   flex items-center justify-between ">

                                                        <div class="flex items-center">

                                                            <div class="flex items-center justify-between w-full pr-12">

                                                                <p class="text-xs italic text-gray-500 ">
                                                                    {{ $breakdown->description }}</p>
                                                                <p class="text-right text-xs italic text-gray-500 ">
                                                                    {{ number_format($breakdown->amount ?? 0) }}</p>

                                                            </div>

                                                        </div>

                                                        <div class="flex items-center  space-x-2">

                                                            <div class="flex items-center">
                                                                <div class="mr-12">

                                                                    @foreach ($breakdown->files as $file)
                                                                        <a href="{{ \Storage::disk('public')->url($file->file) }}"
                                                                            target="_blank"
                                                                            class="mr-2  min-w-40 flex items-center  hover:bg-[#0490b3c7] hover:text-white rounded-lg  justify-start  text-[#0490b3c7] text-xs">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" viewBox="0 0 24 24"
                                                                                stroke="currentColor"
                                                                                class="w-4 h-4 mr-1">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                                            </svg>
                                                                            {{ $file->file_name }}
                                                                        </a>
                                                                    @endforeach
                                                                </div>

                                                                {{ ($this->editBreakDownAction)(['record' => $breakdown->id]) }}
                                                                {{ ($this->deleteBreakDown)(['record' => $breakdown->id]) }}
                                                            </div>


                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            @php

                                                $budget = $expense->p_s_expense->amount;
                                                $total_breakdown = $expense->breakdowns()->sum('amount');
                                                $remaining = $budget - $total_breakdown;
                                                $percentageUsed = ($total_breakdown / $budget) * 100;
                                                $remainingPercentage = 100 - $percentageUsed;

                                            @endphp

                                            @if ($total_breakdown > 0)
                                                <div class="grid grid-cols-4">
                                                    <div class="ml-4 px-2 flex items-center">
                                                        <div class="mr-2 min-w-24 text-right">
                                                            <p class="text-xs">Breakdown Total</p>
                                                        </div>
                                                        <div class="min-w-28 text-left ml-4">
                                                            <p class="text-xs">{{ number_format($total_breakdown) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4 p-4 flex items-center">
                                                        <div class="mr-2 min-w-24 text-right">
                                                            <p class="text-xs">Remaining</p>
                                                        </div>
                                                        <div class="min-w-28 text-left ml-4">
                                                            <p class="text-xs">{{ number_format($remaining) }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4  p-4 flex items-center">
                                                        <div class="mr-2 min-w-24 text-right">
                                                            <p class="text-xs">Percentage Used</p>
                                                        </div>
                                                        <div class="min-w-28 text-left ml-4">
                                                            <p class="text-xs">
                                                                {{ number_format($percentageUsed, 2) }}
                                                                %</p>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4  p-4 flex items-center">
                                                        <div class="mr-2 min-w-24 text-right">
                                                            <p class="text-xs">Remaining Percentage</p>
                                                        </div>
                                                        <div class="min-w-28 text-left ml-4">
                                                            <p class="text-xs">
                                                                {{ number_format($remainingPercentage, 2) }}
                                                                %</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>

                <div class="">
                    <x-sub-total title="Total Fund " :amount="number_format($total_ps ?? 0)" />
                    <x-sub-total title="Total Spend" :amount="number_format($total_ps_breakdown ?? 0)" />
                    <x-sub-total title="Remaining Fund" :amount="number_format($remaining_budget_ps ?? 0)" />
                    <x-sub-total title="Total Percentage Use" :amount="number_format($percentage_used_ps ?? 0) . '%'" />
                    <x-sub-total title="Total Percentage Left" :amount="number_format($remaining_percentage_ps ?? 0) . '%'" />
                </div>


            </div>
        </div> --}}




        {{--
    <div class="mt-4 ">
        <p class="capitalize font-medium ">I. Personal Service</p>

        <div class="grid grid-cols-5 text-sm ">
            <div></div>
            <div class=" flex items-center justify-center">
                <p class="italic text-gray-600 text-sm">

                </p>
            </div>
            <div class=" flex items-center justify center">

            </div>
            <div class=" flex items-center justify-center">
                <p class=" text-gray-900 text-sm font-medium ">
                    Budget
                </p>
            </div>
            <div>

            </div>
        </div>
        @forelse ($personal_services as $cost_type => $personal_service)

            <div>
                <p class=" text-sm font-medium ">{{ $cost_type }}</p>

                <div>
                    @foreach ($personal_service as $group_title => $groups)
                        <div>
                            <p class="text-sm"> {{ $group_title }} </p>
                            @foreach ($groups as $key => $expense)
                                <div class="grid grid-cols-5 text-sm ">

                                    <div class="  flex items-center">

                                        <p class="italic text-gray-600 text-sm">
                                            {{ $expense->p_s_expense->title }}
                                        </p>
                                        <div class="ml-4">

                                            <div>
                                                {{ ($this->addPSBreakDown)(['record' => $expense->id]) }}

                                            </div>



                                        </div>
                                    </div>
                                    <div class=" flex items-center justify-center">
                                        <p class="italic text-gray-600 text-sm">

                                        </p>
                                    </div>
                                    <div class="p-2 flex items-center  ">

                                    </div>
                                    <div class="p-2 flex items-center justify-center ">
                                        {{ $expense->p_s_expense->amount }}
                                    </div>
                                    <div class="  text-right">


                                    </div>

                                </div>

                                <div class="border-t ">
                                    @foreach ($expense->breakdowns as $bk => $breakdown)
                                        <div class="text-xs text-gray-500 border-t grid grid-cols-5 w-full ">
                                            <div class=" p-2">
                                                {{ $breakdown->description }}
                                            </div>
                                            <div class=" p-2">


                                                @foreach ($breakdown->files as $file)
                                                    <a href="{{ \Storage::disk('public')->url($file->file) }}"
                                                        target="_blank" class="  ml-2 flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-4 h-4 mr-2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                        </svg>

                                                        {{ $file->file_name }}
                                                    </a>
                                                @endforeach
                                            </div>
                                           <div class=" p-2 flex items-center ">
                                            {{ number_format($breakdown->amount ?? 0) }}
                                           </div>
                                           <div>

                                           </div>
                                            <div class="flex items-center justify-center">

                                                <div class="flex items-center">
                                                    <div class="mr-2">
                                                        {{ ($this->editBreakDownAction)(['record' => $breakdown->id]) }}

                                                    </div>
                                                    <div>
                                                        {{ ($this->deleteBreakDown)(['record' => $breakdown->id]) }}

                                                    </div>
                                                </div>
                                            </div>




                                        </div>
                                    @endforeach


                                </div>

                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
        @endforelse

        <div class="grid grid-cols-5 bg-gray-100 p-2">
            <div></div>
            <div></div>
            <div></div>
            <div class="flex items-center justify-center">
                {{number_format($total_ps ?? 0)}}
            </div>
            <div></div>
        </div>




    </div> --}}

        {{-- <div class="mt-4 ">
        <p class="capitalize font-medium ">II. Maintenance and Other Operating Expenses</p>
        @forelse ($mooes as $cost_type => $mooe)

            <div>
                <p class=" text-sm font-medium ">{{ $cost_type }}</p>


                <div>
                    @foreach ($mooe as $group_title => $groups)
                        <div class="">
                            <p class="text-sm"> {{ $group_title }} </p>

                            </p>

                            @foreach ($groups as $key => $expense)
                                <div class="">
                                    {{ ($this->addMOOEBreakDown)(['record' => $expense->id]) }}
                                    {{ number_format($expense->amount) }}



                                </div>




                                <div class="ml-8 text-xs text-gray-600">


                                    @foreach ($expense->breakdowns as $bk => $breakdown)
                                        {{ ($this->editBreakDownAction)(['record' => $breakdown->id]) }}
                                        {{ ($this->deleteBreakDown)(['record' => $breakdown->id]) }}
                                        <div class="ml-12  flex items-center ">
                                            <p class="italic text-gray-500 text-xs mr-6">
                                                {{ $breakdown->description }} -
                                            </p>
                                            <p class="text-gray-500 text-xs italic">
                                                {{ number_format($breakdown->amount ?? 0) }}

                                            </p>




                                        </div>

                                        <div>
                                            Files

                                            @foreach ($breakdown->files as $file)
                                                <div class="border-b ">
                                                    <a href="{{ \Storage::disk('public')->url($file->file) }}"
                                                        target="_blank"> {{ $file->file_name }}
                                                    </a>


                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endforeach


                </div>
            </div>
        @empty
        @endforelse


        <x-sub-total title="Sub-total for MOOE" :amount="number_format($total_mooe ?? 0)" />

    </div> --}}

        {{-- <div class="mt-4 ">
        <p class="capitalize font-medium ">III. Capital Outlay</p>
        @forelse ($cos as $cost_type => $co)

            <div>
                <p class=" text-sm font-medium ">{{ $cost_type }}</p>

                <div>

                    @foreach ($co as $key => $expense)
                        {{ ($this->addCOBreakDown)(['record' => $expense->id]) }}
                        <div class="ml-4  flex items-center justify-between">
                            <p class="italic text-gray-600 text-sm">
                                {{ $expense->description }}
                            </p>
                            <p class="text-gray-600 text-sm">
                                {{ number_format($expense->amount) }}
                            </p>

                        </div>

                        <div class="ml-8 text-xs text-gray-600">


                            @foreach ($expense->breakdowns as $bk => $breakdown)
                                {{ ($this->editBreakDownAction)(['record' => $breakdown->id]) }}
                                {{ ($this->deleteBreakDown)(['record' => $breakdown->id]) }}
                                <div class="ml-12  flex items-center ">
                                    <p class="italic text-gray-500 text-xs mr-6">
                                        {{ $breakdown->description }} -
                                    </p>
                                    <p class="text-gray-500 text-xs italic">
                                        {{ number_format($breakdown->amount ?? 0) }}

                                    </p>




                                </div>

                                <div>
                                    Files

                                    @foreach ($breakdown->files as $file)
                                        <div class="border-b ">
                                            <a href="{{ \Storage::disk('public')->url($file->file) }}" target="_blank">
                                                {{ $file->file_name }}
                                            </a>


                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                </div>
            </div>
        @empty
        @endforelse



        <x-sub-total title="Sub-total for CO" :amount="number_format($total_co ?? 0)" />

    </div> --}}

        <x-filament-actions::modals />
    </div>
