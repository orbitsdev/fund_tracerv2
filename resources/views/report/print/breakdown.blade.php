
<x-testlayout>
    <div class="h-screen mt-16 bg-white">
        <div class="rounded bg-white p-8  border-gray-300" id="">
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
    </div>
    
    

    

   


</x-testlayout>
