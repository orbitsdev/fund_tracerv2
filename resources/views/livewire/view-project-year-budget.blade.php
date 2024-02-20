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




    <div class="mt-4 ">
        <p class="capitalize font-medium ">I. Personal Service</p>
        @forelse ($personal_services as $cost_type => $personal_service)

            <div>
                <p class=" text-sm font-medium ">{{ $cost_type }}</p>

                <div>
                    @foreach ($personal_service as $group_title => $groups)
                        <div>
                            <p class="text-sm"> {{ $group_title }} </p>

                            @foreach ($groups as $key => $expense)
                                <div class="ml-4  flex items-center justify-between">
                                    <div class="flex items-center">
                                        <p class="italic text-gray-600 text-sm">
                                            {{ $expense->p_s_expense->title }}
                                        </p>
                                        <div class="ml-4">

                                            <div>
                                                {{ ($this->addPSBreakDown)(['record' => $expense->id]) }}

                                            </div>



                                        </div>
                                    </div>

                                    <p class="text-gray-600 text-sm">
                                        {{ $expense->p_s_expense->amount }}
                                    </p>

                                </div>

                                <div class="ml-8 text-xs text-gray-600">

                                     {{-- @dump($expense->breakdowns) --}}

                                    @foreach ($expense->breakdowns as $breakdown)
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

        <x-sub-total title="Sub-total for PS" :amount="number_format($total_ps ?? 0)" />



    </div>

    <div class="mt-4 ">
        <p class="capitalize font-medium ">II. Maintenance and Other Operating Expenses</p>
        @forelse ($mooes as $cost_type => $mooe)

            <div>
                <p class=" text-sm font-medium ">{{ $cost_type }}</p>


                <div>
                    @foreach ($mooe as $group_title => $groups)


                        <div>
                            <p class="text-sm"> {{ $group_title }} </p>


                            </p>



                            @foreach ($groups as $key => $expense)

                            {{ ($this->addMOOEBreakDown)(['record' => $expense->id]) }}
                                <div class="ml-4  flex items-center justify-between">
                                    <p class="italic text-gray-600 text-sm">
                                        {{ $expense->m_o_o_e_expense->title }}
                                    </p>
                                    <p class="text-gray-600 text-sm">
                                        {{ number_format($expense->amount) }}
                                    </p>

                                </div>

                                <div class="ml-8 text-xs text-gray-600">

                                    {{-- @dump($expense->breakdowns) --}}

                                   @foreach ($expense->breakdowns as $breakdown)
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

    </div>
    <div class="mt-4 ">
        <p class="capitalize font-medium ">III. Capital Outlay</p>
        @forelse ($mooes as $cost_type => $mooe)

            <div>
                <p class=" text-sm font-medium ">{{ $cost_type }}</p>

                <div>

                    <div>
                        <p class="text-sm"> {{ $group_title }} </p>

                        </p>
                        @foreach ($groups as $key => $expense)
                            <div class="ml-4  flex items-center justify-between">
                                <p class="italic text-gray-600 text-sm">
                                    {{ $expense->description }}
                                </p>
                                <p class="text-gray-600 text-sm">
                                    {{ number_format($expense->amount) }}
                                </p>

                            </div>
                        @endforeach
                    </div>



                </div>
            </div>
        @empty
        @endforelse

        <x-sub-total title="Sub-total for CO" :amount="number_format($total_co ?? 0)" />

    </div>
    <x-filament-actions::modals />
</div>
