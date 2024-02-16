<div>
    @php
        $total_ps = $getRecord()->selected_p_ses()->with('p_s_expense')->get()->sum('p_s_expense.amount');
        $total_mooe = $getRecord()->selected_m_o_o_es()->sum('amount');
        $total_co = $getRecord()->selected_c_os()->sum('amount');

        $over_all = ($total_ps  +$total_mooe + $total_co);
    @endphp
    <p class="text-xs">

        {{ number_format($over_all)}}
    </p>

</div>
