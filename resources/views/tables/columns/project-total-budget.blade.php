<div>
    {{-- {{$getRecord()}} --}}
    {{-- @dump($getRecord()->project_years) --}}
    @php
    $project_total_budget= 0;
    foreach ($getRecord()->project_years as $project_year) {
        $total_ps = $project_year->selected_p_ses()->with('p_s_expense')->get()->sum('p_s_expense.amount');
        $total_mooe = $project_year->selected_m_o_o_es()->sum('amount');
        $total_co = $project_year->selected_c_os()->sum('amount');
        $year_total_budget = ($total_ps  +$total_mooe + $total_co);
        $project_total_budget+=$year_total_budget;
    }

    // $project_total_budget=0;
    // foreach($getRecord()->project_years as $project_years) {
    //     # code..        $total_ps = $project_year->selected_p_ses()->with('p_s_expense')->get()->sum('p_s_expense.amount');
    // $total_mooe = $project_year->selected_m_o_o_es()->sum('amount');
    // $total_co = $project_year->selected_c_os()->sum('amount');

    // $year_total_budget = ($total_ps  +$total_mooe + $total_co);
    // $project_total_budget+=$year_total_budget;.
    // }

   @endphp
   <p class=" px-2 p ">
       {{ number_format($project_total_budget)}}

   </p>
</div>
