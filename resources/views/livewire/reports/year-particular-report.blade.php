<div>
    <div class="flex max-w-7xl items-center justify-end">
        <button onclick="printDiv('print-particular-report')" type="button"
            class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 me-2 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
            </svg>
            <span>
                PRINT
            </span>
        </button>




    </div>
    <div id="print-particular-report">

        <div class="flex justify-center items-center mb-6 w-full">
            {{-- <img src="{{ public_path('images/dost.png') }}" alt="DOST Logo" class="h-12 w-12"> --}}
            <div class="text-center">
                <p class="uppercase text-3xl font-medium text-gray-600">Sultan Kudarat State University</p>
                <p class="text-xs text-gray-600">EJC Montilla, 9800, Province of Sultan Kudarat</p>
                <p class="mt-4 text-lg font-medium text-gray-600 uppercase">
                    {{ $record->year->title }}
                </p>

            </div>
            {{-- <img src="{{ public_path('images/sksu.png') }}" alt="SKSU Logo" class="h-12 w-12"> --}}
        </div>

        <p class=" text-xl font-extrabold text-gray-600 text-center uppercase">
            @switch($type)
                @case('ps')
                    PERSONAL SERVICE
                @break

                @case('mooe')
                    Maintenance and Other Operating Expenses
                @break

                @case('co')
                    Capital Outlay
                @break

                @default
                    Default content here
            @endswitch
        </p>





        @switch($type)
            @case('ps')
                <div class="mx-auto max-w-3xl mt-8">
                    @foreach ($record->getSelectedPersonalService() as $cost_type => $personal_service)
                        <div class="bg-gray-100 border rounded p-4 mb-6">
                            <h2 class="text-lg font-semibold text-gray-700">{{ $cost_type }}</h2>

                            @foreach ($personal_service as $group_title => $groups)
                                <div class="mt-4">
                                    <p class="text-lg font-semibold text-gray-700">{{ $group_title }}</p>

                                    @foreach ($groups as $key => $expense)
                                        <div class="flex justify-between items-start mt-2 py-1 px-2 border-b">
                                            <p class="text-sm text-gray-600">{{ $expense->p_s_expense->title }}</p>
                                            <p class="text-sm text-gray-600 text-right">₱
                                                {{ number_format($expense->p_s_expense->amount) }}</p>
                                        </div>

                                        @foreach ($expense->breakdowns as $bk => $breakdown)
                                            <div class="flex justify-between items-start mt-2 py-1 px-2 border-b">
                                                <p class="text-sm text-gray-600">{{ $breakdown->description }}</p>
                                                <p class="text-sm text-gray-600 text-right">₱
                                                    {{ number_format($breakdown->amount) }}</p>
                                            </div>
                                        @endforeach

                                        <div class="mt-2">
                                            <p class="text-sm text-gray-700">Total Spent: ₱
                                                {{ number_format($expense->breakdowns->sum('amount')) }}</p>
                                            <p class="text-sm text-gray-700">Remaining: ₱
                                                {{ number_format($expense->p_s_expense->amount - $expense->breakdowns->sum('amount')) }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach

                        </div>
                    @endforeach
                    <div class="text-right flex items-center justify-between font-bold uppercase text-gray-700">
                        <p>Total</p>
                        <p>₱ {{ $record->getYearTotalPS() }}</p>
                    </div>
                </div>
            @break

            @case('mooe')


                <div class="mx-auto max-w-3xl mt-8">
                    @foreach ($record->getSelectedMOOE() as $cost_type => $mooe)
                        <div class="bg-gray-100 border rounded p-4 mb-6">
                            <h2 class="text-lg font-semibold text-gray-700">{{ $cost_type }}</h2>

                            @foreach ($mooe as $group_title => $groups)
                                <div class="mt-4">
                                    <p class="text-lg font-semibold text-gray-700">{{ $group_title }}</p>

                                    @foreach ($groups as $key => $expense)
                                        <div class="flex justify-between items-start mt-2 py-1 px-2 border-b">
                                            <p class="text-sm text-gray-600">{{ $expense->m_o_o_e_expense->title }}</p>
                                            <p class="text-sm text-gray-600 text-right">₱
                                                {{ number_format($expense->amount) }}</p>
                                        </div>

                                        @foreach ($expense->breakdowns as $bk => $breakdown)
                                            <div class="flex justify-between items-start mt-2 py-1 px-2 border-b">
                                                <p class="text-sm text-gray-600">{{ $breakdown->description }}</p>
                                                <p class="text-sm text-gray-600 text-right">₱
                                                    {{ number_format($breakdown->amount) }}</p>
                                            </div>
                                        @endforeach

                                        <div class="mt-2">
                                            <p class="text-sm text-gray-700">Total Spent: ₱
                                                {{ number_format($expense->breakdowns->sum('amount')) }}</p>
                                            <p class="text-sm text-gray-700">Remaining: ₱
                                                {{ number_format($expense->amount - $expense->breakdowns->sum('amount')) }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach

                        </div>
                    @endforeach
                    <div class="text-right flex items-center justify-between font-bold uppercase text-gray-700">
                        <p>Total</p>
                        <p>₱ {{ $record->getYearTotalMOOE() }}</p>
                    </div>
                </div>
            @break

            @case('co')
                {{-- @dump($record->getSelectedCO()) --}}

                <div class="mx-auto max-w-3xl mt-8">
                    @foreach ($record->getSelectedCO() as $cost_type => $co)
                        <div class="bg-gray-100 border rounded p-4 mb-6">
                            <h2 class="text-lg font-semibold text-gray-700">{{ $cost_type }}</h2>

                            @foreach ($co as $key => $expense)
                            <div class="flex justify-between items-start mt-2 py-1 px-2 border-b">
                                <p class="text-sm text-gray-600">{{ $expense->description }}</p>
                                <p class="text-sm text-gray-600 text-right">₱
                                    {{ number_format($expense->amount) }}</p>
                            </div>

                            @foreach ($expense->breakdowns as $bk => $breakdown)
                                <div class="flex justify-between items-start mt-2 py-1 px-2 border-b">
                                    <p class="text-sm text-gray-600">{{ $breakdown->description }}</p>
                                    <p class="text-sm text-gray-600 text-right">₱
                                        {{ number_format($breakdown->amount) }}</p>
                                </div>
                            @endforeach

                            <div class="mt-2">
                                <p class="text-sm text-gray-700">Total Spent: ₱
                                    {{ number_format($expense->breakdowns->sum('amount')) }}</p>
                                <p class="text-sm text-gray-700">Remaining: ₱
                                    {{ number_format($expense->amount - $expense->breakdowns->sum('amount')) }}
                                </p>
                            </div>
                        @endforeach

                        </div>
                    @endforeach
                    <div class="text-right flex items-center justify-between font-bold uppercase text-gray-700">
                        <p>Total</p>
                        <p>₱ {{ $record->getYearTotalCO() }}</p>
                    </div>
                </div>
            @break

            Noone

            @default
        @endswitch
    </div>

    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;

        }
    </script>
</div>
