
<x-testlayout>
    <div class="h-screen">

        <div class="rounded m-auto max-w-6xl p-4 bg-white">
            <div class="flex justify-between items-center mb-8">
                <img src="{{ public_path('images/dost.png') }}" alt="" class="h-12 w-12">
                <div class="text-center">
                    <p class="uppercase text-3xl font-medium text-gray-600">Sultan Kudarat State University</p>
                    <p class="text-xs text-gray-600">EJC Montilla, 9800, Province of Sultan Kudarat</p>
                    <p class="mt-2 text-lg font-medium text-gray-600">{{ $data->project_year->year->title ?? now()->year }} {{ $selected }} Breakdown</p>
                </div>
                <img src="{{ public_path('images/sksu.png') }}" alt="" class="h-12 w-12">
            </div>

            <div class="mb-8 flex items-center justify-between">
                <p class="mb-2 text-lg font-medium text-gray-600">Total Budget:</p>
                <p class="mb-4 text-lg text-gray-800 text-right">
                    @switch($type)
                        @case('ps')
                            {{ number_format($data->p_s_expense->amount) }}
                            @break
                        @case('mooe')
                            {{ number_format($data->m_o_o_e_expense->amount) }}
                            @break
                        @case('co')
                            {{ number_format($data->amount) }}
                            @break
                        @default
                            0
                    @endswitch
                </p>


            </div>

            <div>
                @php
                    $totalBreakdown = 0;
                @endphp
                @foreach ($data->breakdowns as $breakdown)
                    <div class="flex justify-between items-center mb-2 border-b">
                        <p class="text-gray-800">{{ $breakdown->description }}</p>
                        <p class="text-gray-800">{{ number_format($breakdown->amount) }}</p>
                    </div>
                    @php
                        $totalBreakdown += $breakdown->amount;
                    @endphp
                @endforeach
                <hr class="border-t border-gray-300 mt-4">
                <div class="flex justify-between items-center mb-2">
                    <p class="text-lg font-medium text-gray-600">Total Breakdown:</p>
                    <p class="text-lg font-medium text-gray-800">{{ number_format($totalBreakdown) }}</p>
                </div>
            </div>

            <hr class="border-t border-gray-300 mt-8">

            <div class="mt-4">
                <p class="text-xs text-gray-600">Date: {{ now()->toDateString() }}</p>
                <!-- You can add additional information here if needed -->
            </div>
        </div>

    </div>



</x-testlayout>
