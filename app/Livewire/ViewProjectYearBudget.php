<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SelectedCO;
use App\Models\SelectedPS;
use App\Models\ProjectYear;
use App\Models\SelectedMOOE;

class ViewProjectYearBudget extends Component
{

    public ProjectYear $record;
    public function render()


    {

        $personal_services = SelectedPS::where('project_year_id', $this->record->id)->get()->groupBy('cost_type')->sortBy(function ($group, $key) {
            switch ($key) {
                case 'Direct Cost':
                    return 1;
                case 'Indirect Cost SKSU':
                    return 2;
                case 'Indirect Cost PCAARRD':
                    return 3;
                default:
                    return 4; // Handle any other cases if needed
            }
        })->map(function ($cost_type) {
            return $cost_type->groupBy(function ($cost) {
                return $cost->p_s_group->title;
            });
        });


        $mooes = SelectedMOOE::where('project_year_id', $this->record->id)->get()->groupBy('cost_type')->sortBy(function ($group, $key) {
            switch ($key) {
                case 'Direct Cost':
                    return 1;
                case 'Indirect Cost SKSU':
                    return 2;
                case 'Indirect Cost PCAARRD':
                    return 3;
                default:
                    return 4; // Handle any other cases if needed
            }
        })->map(function ($cost_type) {
            return $cost_type->groupBy(function ($cost) {
                return $cost->m_o_o_e_group->title;
            });
        });


        $cos = SelectedCO::where('project_year_id', $this->record->id)->get()->groupBy('cost_type')->sortBy(function ($group, $key) {
            switch ($key) {
                case 'Direct Cost':
                    return 1;
                case 'Indirect Cost SKSU':
                    return 2;
                case 'Indirect Cost PCAARRD':
                    return 3;
                default:
                    return 4; // Handle any other cases if needed
            }
        });

        #total

        $total_ps = SelectedPS::where('project_year_id', $this->record->id)->with('p_s_expense')->get()->sum('p_s_expense.amount');
        $total_mooe = SelectedMOOE::where('project_year_id', $this->record->id)->sum('amount');
        $total_co = SelectedCO::where('project_year_id', $this->record->id)->sum('amount');


        return view('livewire.view-project-year-budget',compact(
            'total_ps',
            'total_mooe',
            'total_co',
            'personal_services',
            'mooes',
            'cos'
        ));
    }
}
