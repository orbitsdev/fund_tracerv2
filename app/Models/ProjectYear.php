<?php

namespace App\Models;

use App\Models\Year;
use App\Models\Project;
use App\Models\SelectedCO;
use App\Models\SelectedMOOE;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class ProjectYear extends Model
{
    use HasFactory;

    public const STATUS_FOR_EDITING = 'For Editing';
    public const STATUS_APPROVED = 'Approved';
    public const STATUS_FOR_REVIEW = 'For Review'; 
    public const STATUS_REVIEWING = 'Reviewing'; 
    public const STATUS_REJECTED = 'Denied';


    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function selected_p_ses()
    {
        return $this->hasMany(SelectedPS::class);
    }
    public function selected_m_o_o_es()
    {
        return $this->hasMany(SelectedMOOE::class);
    }
    public function selected_c_os()
    {
        return $this->hasMany(SelectedCO::class);
    }



    public function getSelectedPersonalService()
    {
        return  $this->selected_p_ses()->get()->groupBy('cost_type')->sortBy(function ($group, $key) {
            switch ($key) {
                case 'Direct Cost':
                    return 1;
                case 'Indirect Cost SKSU':
                    return 2;
                case 'Indirect Cost DOST':
                    return 3;
                default:
                    return 4; // Handle any other cases if needed
            }
        })->map(function ($cost_type) {
            return $cost_type->groupBy(function ($cost) {
                return $cost->p_s_group->title;
            });
        });
    }
    public function getSelectedMOOE()
    {
        return  $this->selected_m_o_o_es()->get()->groupBy('cost_type')->sortBy(function ($group, $key) {
            switch ($key) {
                case 'Direct Cost':
                    return 1;
                case 'Indirect Cost SKSU':
                    return 2;
                case 'Indirect Cost DOST':
                    return 3;
                default:
                    return 4; // Handle any other cases if needed
            }
        })->map(function ($cost_type) {
            return $cost_type->groupBy(function ($cost) {
                return $cost->m_o_o_e_group->title;
            });
        });
    }
    public function getSelectedCO()
    {
        return  $this->selected_c_os()->get()->groupBy('cost_type')->sortBy(function ($group, $key) {
            switch ($key) {
                case 'Direct Cost':
                    return 1;
                case 'Indirect Cost SKSU':
                    return 2;
                case 'Indirect Cost DOST':
                    return 3;
                default:
                    return 4; // Handle any other cases if needed
            }
        });
    }

    public function getYearTotalBudget()
    {
        $total_ps = $this->selected_p_ses()->with('p_s_expense')->get()->sum(function ($selectedPS) {
            return $selectedPS->amount ?? 0;
        });

        $total_mooe = $this->selected_m_o_o_es()->sum('amount');
        $total_co = $this->selected_c_os()->sum('new_amount');

        return $total_ps + $total_mooe + $total_co;
    }


    public function getYearTotalPS()
    {
        $total_spent_ps = $this->selected_p_ses()->with('breakdowns')->get()->sum(function ($selectedPS) {
            return $selectedPS->breakdowns->sum('amount') ?? 0;
        });



        return $total_spent_ps;
    }
    public function getYearTotalMOOE()
    {
        $total_spent_mooe = $this->selected_m_o_o_es()->with('breakdowns')->get()->sum(function ($selectedMOOE) {
            return $selectedMOOE->breakdowns->sum('amount') ?? 0;
        });



        return $total_spent_mooe;
    }
    public function getYearTotalCO()
    {
        $total_spent_co = $this->selected_c_os()->with('breakdowns')->get()->sum(function ($selectedCO) {
            return $selectedCO->breakdowns->sum('amount') ?? 0;
        });



        return $total_spent_co;
    }
    public function getYearTotalSpent()
    {
        $total_spent_ps = $this->selected_p_ses->sum(fn($item) => $item->totalSpent());
        $total_spent_mooe = $this->selected_m_o_o_es->sum(fn($item) => $item->totalSpent());
        $total_spent_co = $this->selected_c_os->sum(fn($item) => $item->totalSpent());

        return ($total_spent_ps + $total_spent_mooe + $total_spent_co);
    }

    public function getYearRemainingBudget()
    {
        $total_budget = $this->getYearActualBudget();
        $total_spent = $this->getYearTotalSpent();

        $remaining = ($total_budget - $total_spent);

        return $remaining;
    }

    public function getBudgetPercentageUse()
    {
        $total_budget = $this->getYearActualBudget();
        $total_spent = $this->getYearTotalSpent();

        $percentage_used = ($total_budget != 0) ? ($total_spent / $total_budget) * 100 : 0;

        return $percentage_used;
    }

    public function getActualTotalPS()
    {
        return  $this->selected_p_ses()->sum('amount');
    }
    public function getActualTotalMOOE()
    {
        return  $this->selected_m_o_o_es()->sum('amount');
    }
    public function getActualTotalCO()
    {
        return  $this->selected_c_os()->sum('new_amount');
    }

    public function getYearActualBudget()
    {
        return ($this->getActualTotalPS() + $this->getActualTotalMOOE() + $this->getActualTotalCO());
    }



    public function getYearTotalPsBreakDown()
    {
        return $this->selected_p_ses->sum(function ($item) {
            return $item->totalSpent();
        });
    }
    public function getYearTotalMOOEBreakDown()
    {
        return $this->selected_m_o_o_es->sum(function ($item) {
            return $item->totalSpent();
        });
    }
    public function getYearTotalCOBreakDown()
    {
        return $this->selected_c_os->sum(function ($item) {
            return $item->totalSpent();
        });
    }

    public function getPSTotalRemainingBudget()
    {
        return ($this->getActualTotalPS() - $this->getYearTotalPsBreakDown());
    }
    public function getPSTotalUsePercentage()
    {
        return $this->getActualTotalPS() != 0 ? ($this->getYearTotalPsBreakDown() / $this->getActualTotalPS()) * 100 : 0;
    }


    public function getMOOETotalRemainingBudget(){
      return ($this->getActualTotalMOOE() - $this->getYearTotalMOOEBreakDown());
    }

    public function getMOOETotalUsePercentage()
    {
        return $this->getActualTotalMOOE() != 0 ? ($this->getYearTotalMOOEBreakDown() / $this->getActualTotalMOOE()) * 100 : 0;
    }

    public function getCOTotalRemainingBudget(){
      return ($this->getActualTotalCO() - $this->getYearTotalCOBreakDown());
    }

    public function getCOTotalUsePercentage()
    {
        return $this->getActualTotalCO() != 0 ? ($this->getYearTotalCOBreakDown() / $this->getActualTotalCO()) * 100 : 0;
    }


}
