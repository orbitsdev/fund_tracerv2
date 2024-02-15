<div>

    <x-create-management-layout>
        {{-- {{$record}} --}}
        <div class="mb-4">
            <p class="text-primary-700 text-4xl  font-medium"> {{ $record->year->title }}</p>

        </div>
        <div>
            <p class="text-primary-600 text-3xl font-medium"> I. Personal Service</p>
            <div class="mt-4">
                {{ $this->addPersonalServiceAction }}
            </div>

            <div class="mt-4">
                @forelse ($personal_services as $cost_type => $personal_service)
                    <div class="">
                        <p class="font-bold text-gray-600">

                            {{ $cost_type }}
                        </p>
                        <div class="ml-4">
                            {{-- @dump($personal_service) --}}
                            @foreach ($personal_service as $group_title => $groups)
                                <div class="ml-4 ">
                                    <p class="font-medium text-gray-600">
                                        {{ $group_title }}

                                    </p>
                                    @foreach ($groups as $key => $expense)
                                        <div class="flex justify-between   items-center border-b hover:bg-gray-50">

                                            <div class="ml-4 mr-4  flex   justify-between  text-gray-600 w-full    ">
                                                <p class="italic">
                                                    {{ $expense->p_s_expense->title }}
                                                </p>
                                                <p>
                                                    {{ number_format($expense->p_s_expense->amount) }}
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
            <div class="pr-8 flex justify-between p-1 bg-gray-100 ">
                <div>

                </div>
                <div class="flex font-medium">

                    <p class=" ">
                        Sub-total for PS
                    </p>
                    <p class="w-[200px] text-end mr-6">
                        {{ number_format($total_ps) }}
                    </p>
                </div>
            </div>

        </div>
        <div class="mt-6">
            <p class="text-primary-600 text-3xl font-medium"> II. Maintenance and Other Operating Expenses</p>
            <div class="mt-4">
                {{ $this->addMOOEAction }}
            </div>

            <div class="mt-4">
                @forelse ($mooes as $cost_type => $mooe)
                    <div class="">
                        <p class="font-bold text-gray-600">

                            {{ $cost_type }}
                        </p>
                        <div class="ml-4">
                            {{-- @dump($personal_service) --}}
                            @foreach ($mooe as $group_title => $groups)
                                <div class="ml-4 ">
                                    <p class="font-medium text-gray-600">
                                        {{ $group_title }}

                                    </p>
                                    @foreach ($groups as $key => $expense)
                                        <div class="flex justify-between   items-center border-b hover:bg-gray-50">

                                            <div class="ml-4 mr-4  flex   justify-between  text-gray-600 w-full    ">
                                                <p class="italic">
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
            <div class="pr-8 flex justify-between p-1 bg-gray-100 ">
                <div>

                </div>
                <div class="flex font-medium">

                    <p class=" ">
                        Sub-total for MOOE
                    </p>
                    <p class="w-[200px] text-end mr-6">
                    {{ number_format($total_mooe) }}
                    </p>
                </div>
            </div>

        </div>
        <div>

            <div class="mt-7 pr-8 flex justify-between text-3xl mb-8 text-gray-700">
                <div>

                </div>
                <div class="flex font-medium">

                    <p class=" ">
                        Total Proposed Budget:
                    </p>
                    <p class="w-[200px] text-end mr-6">
                        {{ number_format(($total_budet)) }}
                    </p>
                </div>
            </div>

        </div>
        <x-filament-actions::modals />
    </x-create-management-layout>
</div>
