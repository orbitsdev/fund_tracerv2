<?php

namespace App\Models;

use App\Models\MOOEGroup;
use App\Models\MOOEExpense;
use App\Models\ProjectYear;
use App\Models\SPSBreakdown;
use App\Models\MOOEBreakdown;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SelectedMOOE extends Model
{
    use HasFactory;

    public function m_o_o_e_group(){
        return $this->belongsTo(MOOEGroup::class);
    }
    public function m_o_o_e_expense(){
        return $this->belongsTo(MOOEExpense::class);
    }
    public function project_year(){
        return $this->belongsTo(ProjectYear::class);
    }

    public function m_o_o_e_breakdowns(){
        return $this->hasMany(MOOEBreakdown::class);
    }
}
