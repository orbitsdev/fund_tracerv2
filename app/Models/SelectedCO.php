<?php

namespace App\Models;

use App\Models\Breakdown;
use App\Models\ProjectYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SelectedCO extends Model
{
    use HasFactory;

    public function project_year(){
        return $this->belongsTo(ProjectYear::class);
    }


    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
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
        $budget = $this->new_amount;
        $totalExpense = $this->totalSpent();

        // Calculate the percentage used
        $totalPercentage = $budget != 0 ? ($totalExpense / $budget) * 100 : 0;
        return $totalPercentage;
    }

    public function remainingBudget()
    {
        $budget = $this->new_amount;
        $totalExpense = $this->totalSpent();

        // Calculate the remaining budget
        $remainingBudget = $budget - $totalExpense;
        return $remainingBudget;
    }

    public function remainingPercentage()
    {
        $budget = $this->new_amount;
        $totalExpense = $this->totalSpent();
        $remainingBudget = $budget - $totalExpense;

        // Calculate the remaining percentage
        $remainingPercentage = $budget != 0 ? ($remainingBudget / $budget) * 100 : 0;
        return $remainingPercentage;
    }

    public function getTotalCoPerYear($record){
        $total_co = SelectedCO::where('project_year_id', $record)->sum('new_amount');
       return $total_co;
    }
}
