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

class SelectedPS extends Model
{
    use HasFactory;

    public function p_s_group(){
        return $this->belongsTo(PSGroup::class);
    }
    public function p_s_expense(){
        return $this->belongsTo(PSExpense::class);
    }
    public function project_year(){
        return $this->belongsTo(ProjectYear::class);
    }

    public function s_p_s_breakdowns(){
        return $this->hasMany(SPSBreakdown::class);
    }

    // public function tests(): MorphMany
    // {
    //     return $this->morphMany(Test::class, 'testable');
    // }

    // public function test(): MorphOne
    // {
    //     return $this->morphOne(Test::class, 'testable');
    // }

    public function breakdown(): MorphOne
    {
        return $this->morphOne(Breakdown::class, 'breakdownable');
    }

    public function breakdowns(): MorphMany
    {
        return $this->morphMany(Breakdown::class, 'breakdownable');
    }
}
