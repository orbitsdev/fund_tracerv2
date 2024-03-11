<?php

namespace App\Models;

use App\Models\Test;
use App\Models\PSGroup;
use App\Models\Breakdown;
use App\Models\PSExpense;
use App\Models\ProjectYear;
use App\Models\SPSBreakdown;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class SelectedPS extends Model
{
    use HasFactory;

    public function p_s_group()
    {
        return $this->belongsTo(PSGroup::class);
    }
    public function p_s_expense()
    {
        return $this->belongsTo(PSExpense::class);
    }
    public function project_year()
    {
        return $this->belongsTo(ProjectYear::class);
    }

    public function s_p_s_breakdowns()
    {
        return $this->hasMany(SPSBreakdown::class);
    }


    public function breakdown(): MorphOne
    {
        return $this->morphOne(Breakdown::class, 'breakdownable');
    }

    public function breakdowns(): MorphMany
    {
        return $this->morphMany(Breakdown::class, 'breakdownable');
    }


    public function getTotalBudget()
    {
        return $this->amount;
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
    public function scopeGroup($query, $record)
    {
        return $query->where('id', $record)
            ->with('p_s_expense') // Ensure the relationship is eager loaded
            ->get()
            ->groupBy('p_s_expense.title');
    }



    public function displaySelectedPS() {
        switch ($this->p_s_expense->p_s_expense_type->title) {
            case 'month':
                return "(" . $this->number_of_positions . ") " . $this->p_s_expense->title . " " . number_format($this->p_s_expense->amount) . "/mo x " . $this->duration . " mos";
                break;

            case 'quarter':
                return "(" . $this->number_of_positions . ") " . $this->p_s_expense->title . " " . number_format($this->p_s_expense->amount) . "/qtr";
                break;

            default:
                return "(" . $this->number_of_positions . ") " . $this->p_s_expense->title . " " . number_format($this->p_s_expense->amount) . "(" . $this->p_s_expense->p_s_expense_type->title . ")";
        }
    }

}
