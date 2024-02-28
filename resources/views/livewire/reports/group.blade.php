<div>
    {{-- @dump($record->selected_p_ses) --}}

    <div class="text-center">
        <p class="uppercase text-3xl font-medium text-gray-600">Sultan Kudarat State University</p>
        <p class="text-xs text-gray-600">EJC Montilla, 9800, Province of Sultan Kudarat</p>
        <p class="mt-2 text-lg font-medium text-gray-600">
                {{$record}}
                {{$record->title}}
        </p>
        <p class="text-lg font-medium text-gray-600">
        </p>
    </div>

    @foreach ($record->selected_p_ses()->where('project_year_id', $year)->get() as $expense)
        <div class="bg-gray-100 border-b p-2 text-gray-600">

            @dump($expense->p_s_expense->title)
        </div>
    @endforeach
</div>

