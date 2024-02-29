<?php

namespace App\Models;

use App\Models\PSExpense;
use App\Models\SelectedPS;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PSGroup extends Model
{
    use HasFactory;
    public function p_s_expenses()
    {
        return $this->hasMany(PSExpense::class);
    }
    public function selected_p_ses()
    {
        return $this->hasMany(SelectedPS::class);
    }


    public function getSelectedPs($year)
    {
        $selected_ps = $this->selected_p_ses()->where('project_year_id', $year)->get();
        return $selected_ps;
    }

    public function totalPSPerGroup($year)
    {
        $total = 0;
        foreach ($this->getSelectedPs($year) as  $data) {
            $total += $data->totalSpent();
        }
        return $total;
    }
}
