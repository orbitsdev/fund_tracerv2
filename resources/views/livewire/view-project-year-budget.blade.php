<div>

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
    {{-- <div>
        <div class="text-sm flex flex-col items-center">
            <p>Dost Form 4</p>
            <p>Department OF SCIENCE AND TECHNOLOGY</p>
            <p>Project Line Item Budget</p>
            <p>{{now()->year}}</p>

        </div>

        <div class="flex items-center text-sm">
            <div class="w-[200px] text-sm">
                Project Title
            </div>
            <div class="h font-bold">
                {{$record->project->title}}
            </div>
        </div>
        <div class="flex items-center text-sm">
            <div class="w-[200px] text-sm">
                Implementing Agency
            </div>
            <div class="h font-bold">
                {{$record->project->implementing_agency}}
            </div>
        </div>
        <div class="flex items-center text-sm">
            <div class="w-[200px] text-sm">
                Total Duration
            </div>
            <div class="h font-bold">
                @if ($record->project->start_date && $record->project->end_date)

                    @php
                        $startDate = \Carbon\Carbon::parse($record->project->start_date);
                        $endDate = \Carbon\Carbon::parse($record->project->end_date);

                        $totalMonths = $endDate->diffInMonths($startDate);
                    @endphp

                    {{ $totalMonths . ''}} months

            @endif
            </div>
        </div>
         <div class="flex items-center">
        <div class="w-[200px] text-sm">
            Project Leader
        </div>
        <div class="h font-bold">
            {{$record->project->project_leader}}
        </div>
    </div>
    </div> --}}


    <div class="bg-white rounded-lg shadow-md p-4">
        <h1 class="text-xl font-medium mb-2">Project {{ $record->year->title }} Budget and Expenses Breakdown</h1>
        <p class=" mb-4 text-xs text-gray-600">This document provides a detailed breakdown of the budget allocation for
            the {{ $record->year->title }} project, outlining various line items and expenses. It serves as a
            comprehensive financial plan to track and manage expenses throughout the project lifecycle.</p>

        <div class="border-t border-gray-200 pt-2">
            <h2 class="text-md font-semibold mb-2 ">I. Personal Service</h2>
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

                                            <div class="bg-[#0e343dfa] px-6 ml-4 flex justify-between items-center  text-white  ">
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

                                                            <p class="text-xs italic text-gray-400 ">
                                                                {{ $breakdown->description }}</p>
                                                            <p class="text-right text-xs italic text-gray-400 ">
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
                                                                            stroke="currentColor" class="w-4 h-4 mr-1">
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

                                        @endphp

                                        @if($total_breakdown > 0)
                                        <div class="grid grid-cols-5  ">


                                        <div class="ml-4 col-start-1 col-end-2    px-2 flex items-center">

                                            <div class="mr-2 min-w-24 text-right">

                                                <p class="text-xs ">
                                                     Breakdown Total

                                                </p>
                                            </div>
                                            <div class="min-w-28 text-left ml-4">

                                                <p class="text-xs">
                                                    {{number_format($total_breakdown)}}

                                                </p>

                                            </div>
                                        </div>

                                        <div class="ml-4 col-start-2 col-end-4 p-4  flex items-center">

                                            <div class="mr-2 min-w-24 text-right">

                                                <p class="text-xs ">
                                                    Remaining

                                                </p>
                                            </div>
                                            <div class="min-w-28 text-left ml-4">


                                                <p class="text-xs ">

                                                    {{ number_format($remaining) }}
                                                </p>

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
        </div>
    </div>




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
