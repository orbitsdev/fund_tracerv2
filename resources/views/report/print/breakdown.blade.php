
<x-testlayout>
    <div class="h-screen mt-16 bg-gray-100 flex justify-center items-center">
        <div class="rounded bg-white shadow-md p-8 max-w-xl w-full">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Sultan Kudarat State University</h1>
                <p class="text-sm text-gray-600">EJC Montilla, 9800, Province of Sultan Kudarat</p>
                <p class="mt-2 text-lg font-medium text-gray-700">
                    {{ isset($data->project_year->year->title) ? $data->project_year->year->title : now()->year }}
                </p>
                <p class="text-lg font-medium text-gray-700">
                    {{ $selected }}
                </p>
            </div>

            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <p class="text-lg font-medium text-gray-700">Total Budget:</p>
                    <p class="text-lg text-gray-800">
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

                <div class="rounded font-normal">
                    @foreach ($data->breakdowns as $index => $breakdown)
                        <div class="flex justify-between items-center p-2 text-sm mb-1 bg-gray-200 {{$loop->last ? '' : ''}}">
                            <p class="text-gray-600">{{ $breakdown->description }}</p>
                            <p class="text-gray-600">₱ {{ number_format($breakdown->amount) }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between items-center mb-2">
                    <p class="text-lg font-medium text-gray-700">Total Breakdown:</p>
                    <p class="text-lg font-medium text-gray-800">₱ {{ number_format($data->totalSpent()) }}</p>
                </div>

                <div class="flex justify-between items-center mb-2">
                    <p class="text-lg font-medium text-gray-700">Remaining Budget:</p>
                    <p class="text-lg font-medium text-green-600">₱ {{ number_format($data->remainingBudget()) }}</p>
                </div>

                <div class="flex justify-between items-center mb-2">
                    <p class="text-lg font-medium text-gray-700">Percentage Used:</p>
                    <p class="text-lg font-medium text-red-600">{{ number_format($data->totalPercentageUse()) }}%</p>
                </div>
            </div>

            <hr class="border-t border-gray-300 mt-8">

            <div class="mt-4 text-center">
                <p class="text-xs text-gray-600">Date: {{ now()->toDateString() }}</p>
                <!-- Additional information can be added here if needed -->
            </div>
        </div>
    </div>







</x-testlayout>
