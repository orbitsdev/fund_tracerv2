<?php

namespace App\Models;

use App\Models\MOOEGroup;
use App\Models\MOOEExpense;
use App\Models\ProjectYear;
use App\Models\SPSBreakdown;
use App\Models\MOOEBreakdown;
use App\Models\MOOEExpenseSub;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SelectedMOOE extends Model
{
    use HasFactory;

    public function project_year(){
        return $this->belongsTo(ProjectYear::class);
    }
    public function m_o_o_e_group(){
        return $this->belongsTo(MOOEGroup::class);
    }
    public function m_o_o_e_expense(){
        return $this->belongsTo(MOOEExpense::class);
    }
    public function m_o_o_e_expense_sub(){
        return $this->belongsTo(MOOEExpenseSub::class);
    }

    public function m_o_o_e_breakdowns(){
        return $this->hasMany(MOOEBreakdown::class);
    }

    public function breakdown(): MorphOne
    {
        return $this->morphOne(Breakdown::class, 'breakdownable');
    }

    public function breakdowns(): MorphMany
    {
        return $this->morphMany(Breakdown::class, 'breakdownable');
    }


    public function totalSpent()
    {
        return $this->breakdowns()->sum('amount');
    }

    public function totalPercentageUse()
    {
        $budget = $this->amount;
        $totalExpense = $this->totalSpent();

        // Calculate the percentage used
        $totalPercentage = $budget != 0 ? ($totalExpense / $budget) * 100 : 0;
        return $totalPercentage;
    }

    public function remainingBudget()
    {
        $budget = $this->amount;
        $totalExpense = $this->totalSpent();

        // Calculate the remaining budget
        $remainingBudget = $budget - $totalExpense;
        return $remainingBudget;
    }

    public function remainingPercentage()
    {
        $budget = $this->amount;
        $totalExpense = $this->totalSpent();
        $remainingBudget = $budget - $totalExpense;

        // Calculate the remaining percentage
        $remainingPercentage = $budget != 0 ? ($remainingBudget / $budget) * 100 : 0;
        return $remainingPercentage;
    }
}
