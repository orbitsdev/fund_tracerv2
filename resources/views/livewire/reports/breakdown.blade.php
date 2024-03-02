
    <div class="h-screen mt-16 bg-white p-10">
        <div class="flex max-w-7xl items-center justify-end">
            <button  onclick="printDiv('print-content')" type="button" class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 me-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                  </svg>
    <span>
    PRINT
    </span>
                </button>

            <a href="{{route('project.line-items-view', ['record'=> $data->id])}}"  class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 me-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                  </svg>

    <span>
    BACK
    </span>
                </a>


        </div>
        <div class="rounded bg-white p-8  border-gray-300" id="print-content">
            <div class="flex justify-center items-center mb-8 w-full">
                {{-- <img src="{{ public_path('images/dost.png') }}" alt="DOST Logo" class="h-12 w-12"> --}}
                <div class="text-center">
                    <p class="uppercase text-3xl font-medium text-gray-600">Sultan Kudarat State University</p>
                    <p class="text-xs text-gray-600">EJC Montilla, 9800, Province of Sultan Kudarat</p>
                    <p class="mt-2 text-lg font-medium text-gray-600">
                        @if(isset($data->project_year->year->title))
                            {{ $data->project_year->year->title }}
                        @else
                            {{ now()->year }}
                        @endif
                    </p>
                    <p class="text-lg font-medium text-gray-600">
                         {{ $selected }}
                    </p>
                </div>
                {{-- <img src="{{ public_path('images/sksu.png') }}" alt="SKSU Logo" class="h-12 w-12"> --}}
            </div>

            <div class="mb-6 flex items-center justify-between">
                <p class="mb-2 text-lg font-medium text-gray-600">Total Budget:</p>
                <p class="mb-4 text-lg text-gray-700 text-right">
                    @switch($type)
                        @case('ps')
                            ₱ {{ number_format($data->p_s_expense->amount) }}
                            @break
                        @case('mooe')
                            ₱ {{ number_format($data->m_o_o_e_expense->amount) }}
                            @break
                        @case('co')
                            ₱ {{ number_format($data->amount) }}
                            @break
                        @default
                            ₱ 0
                    @endswitch
                </p>
            </div>

            <div class="rounded font-normal ">
                @foreach ($data->breakdowns as $index => $breakdown)
                    <div class="flex justify-between items-center p-2 text-sm  mb-1  bg-gray-50 {{$loop->last ? '' : ''}}">
                        <p class="text-gray-600">{{ $breakdown->description }}</p>
                        <p class="text-gray-600">₱ {{ number_format($breakdown->amount) }}</p>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-between items-center mb-2">
                <p class="text-lg font-medium text-gray-600">Total Breakdown:</p>
                <p class="text-lg font-medium text-gray-700">₱ {{ number_format($data->totalSpent()) }}</p>
            </div>

            <div class="flex justify-between items-center mb-2">
                <p class="text-lg font-medium text-gray-600">Remaining Budget:</p>
                <p class="text-lg font-medium text-green-600">₱ {{ number_format($data->remainingBudget()) }}</p>
            </div>

            <div class="flex justify-between items-center mb-2">
                <p class="text-lg font-medium text-gray-600">Percentage Used:</p>
                <p class="text-lg font-medium text-red-600">{{ number_format($data->totalPercentageUse()) }}%</p>
            </div>

            <hr class="border-t border-gray-300 mt-8">

            <div class="mt-4">
                <p class="text-xs text-gray-600">Date: {{ now()->toDateString() }}</p>
                <!-- Additional information can be added here if needed -->
            </div>
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


