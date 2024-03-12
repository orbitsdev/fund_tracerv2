<div>

    <x-create-management-layout>
        {{-- <div class="p-2 bg-indigo-100 rounded-md drop-shadow-sm mb-2">

        </div> --}}

        <x-back-button style="justify-start" :url="route('project.line-item-budget',['record' => $record->project->id])">
            Back
        </x-bacl-button>
        {{-- {{$record}} --}}
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
                @forelse ($personal_services as $cost_type => $personal_service)
                    <div class="mt-4">
                        <p class="font-bold text-gray-600">

                            {{ $cost_type }}
                        </p>
                        <div class="ml-4">
                            {{-- @dump($personal_service) --}}
                            @foreach ($personal_service as $group_title => $groups)
                                <div class="ml-4 ">
                                    <p clwess="font-medium text-gray-600">
                                        {{ $group_title }}

                                    </p>
                                    @foreach ($groups as $key => $expense)
                                        <div class="flex justify-between   items-center border-b hover:bg-gray-50">

                                            <div class="ml-4 mr-4  flex   justify-between  text-gray-600 w-full    ">
                                                <p class="italic text-sm text-gray-500">
                                                    {{-- @dump() --}}
                                                   {{$expense->displaySelectedPS()}}
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
                                                {{-- <x-edit-button> x</x-edit-button> --}}
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
                @forelse ($mooes as $cost_type => $mooe)
                    <div class="mt-4">
                        <p class="font-bold text-gray-600">

                            {{ $cost_type }}
                        </p>
                        <div class="ml-4">
                            {{-- @dump($personal_service) --}}
                            @foreach ($mooe as $group_title => $groups)
                                <div class="ml-4 
                                    <p class="font-medium text-gray-600">
                                        {{ $group_title }}

                                    </p>
                                    @foreach ($groups as $key => $expense)
                                        <div class="flex justify-between   items-center border-b hover:bg-gray-50">

                                            <div class="ml-4 mr-4  flex   justify-between  text-gray-600 w-full    ">
                                                <p class="italic text-sm text-gray-500">
                                                  ({{$expense->specification}})  {{ $expense->m_o_o_e_expense->title }}
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
                                                {{-- <x-edit-button> x</x-edit-button> --}}
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
        <x-filament-actions::modals />
    </x-create-management-layout>
</div>
