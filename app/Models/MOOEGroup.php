<?php

namespace App\Models;

use App\Models\MOOEExpense;
use App\Models\SelectedMOOE;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MOOEGroup extends Model
{
    use HasFactory;

    public function m_o_o_e_expenses(){
        return $this->hasMany(MOOEExpense::class);
    }

    public function selected_m_o_o_eses()
    {
        return $this->hasMany(SelectedMOOE::class);
    }

    public function getSelectedMOOE($year)
    {
        $selected_mooes = $this->selected_m_o_o_eses()->where('project_year_id', $year)->get();
        return $selected_mooes;
    }

    public function totalMOOEPerGroup($year)
    {
        $total = 0;
        foreach ($this->getSelectedMOOE($year) as  $data) {
            $total += $data->totalSpent();
        }
        return $total;
    }

}
