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
    <div>
        <p>Dost Form 4</p>
        <p>Department OF SCIENCE AND TECHNOLOGY</p>
        <p>Project Line Item Budget</p>
        <p>{{now()->year}}</p>

    </div>

    <div class="flex items-center">
        <div class="w-[200px]">
            Project Title
        </div>
        <div class="h">
            {{$record->project->title}}
        </div>
    </div>
    <div class="flex items-center">
        <div class="w-[200px]">
            Implementing Agency
        </div>
        <div class="h">
            {{$record->project->implementing_agency}}
        </div>
    </div>
    <div class="flex items-center">
        <div class="w-[200px]">
            Total Duration
        </div>
        <div class="h">
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
        <div class="w-[200px]">
            Project Leader
        </div>
        <div class="h">
            {{$record->project->project_leader}}
        </div>
    </div>
</div>
