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

    <x-back-button :url="route('project.line-item-budget',['record'=> $record->project_id])">Back</x-back-button>
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

                    // Calculate the difference in months
                    $totalMonths = $endDate->diffInMonths($startDate);
                @endphp
                {{-- {{ $thirdlayer->parent_title }} --}}
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


    <div class="mt-4 ">
        <p class="capitalize font-medium ">I. Personal Service</p>
        @forelse ($personal_services as $cost_type => $personal_service)

        <div>
            <p class=" text-sm font-medium ">{{ $cost_type }}</p>

            <div>
                @foreach ($personal_service as $group_title => $groups)
                <div>
                    <p class="text-sm">    {{ $group_title }}  </p>

                    @foreach ($groups as $key => $expense)
                    <div class="ml-4  flex items-center justify-between">
                        <p class="italic text-gray-600 text-sm">
                            {{ $expense->p_s_expense->title }}
                        </p>
                        <p class="text-gray-600 text-sm">
                            {{ $expense->p_s_expense->amount }}
                        </p>

                    </div>
                        @endforeach
                </div>


                @endforeach
            </div>
        </div>
        @empty
        @endforelse

        <div class="flex items-center justify-between">
            <div></div>
            <p class="text-sm">
                Sub-total for PS
            </p>
            <p>
                {{ number_format($total_ps) }}

            </p>
        </div>
    </div>

    <div class="mt-4 ">
        <p class="capitalize font-medium ">II. Maintenance and Other Operating Expenses</p>
        @forelse ($mooes as $cost_type => $mooe)

        <div>
            <p class=" text-sm font-medium ">{{ $cost_type }}</p>

            <div>
                @foreach ($mooe as $group_title => $groups)
                <div>
                    <p class="text-sm">    {{ $group_title }}  </p>

                </p>
                @foreach ($groups as $key => $expense)
                    <div class="ml-4  flex items-center justify-between">
                        <p class="italic text-gray-600 text-sm">
                            {{ $expense->m_o_o_e_expense->title }}
                        </p>
                        <p class="text-gray-600 text-sm">
                            {{ number_format($expense->amount) }}
                        </p>

                    </div>
                        @endforeach
                </div>
                @endforeach


            </div>
        </div>
        @empty
        @endforelse
        <div class="flex items-center justify-between">
            <div></div>
            <p class="text-sm">
                Sub-total for MOOE
            </p>
            <p>
                {{ number_format($total_mooe) }}

            </p>
        </div>
    </div>
    <div class="mt-4 ">
        <p class="capitalize font-medium ">III. Capital Outlay</p>
        @forelse ($mooes as $cost_type => $mooe)

        <div>
            <p class=" text-sm font-medium ">{{ $cost_type }}</p>

            <div>

                <div>
                    <p class="text-sm">    {{ $group_title }}  </p>

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
        <div class="flex items-center justify-between">
            <div></div>
            <p class="text-sm">
                Sub-total for MOOE
            </p>
            <p>
                {{ number_format($total_co) }}

            </p>
        </div>
    </div>

</div>
