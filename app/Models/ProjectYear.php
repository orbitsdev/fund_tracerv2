<?php

namespace App\Models;

use App\Models\Year;
use App\Models\Project;
use App\Models\SelectedCO;
use App\Models\SelectedMOOE;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectYear extends Model
{
    use HasFactory;

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function year(){
        return $this->belongsTo(Year::class);
    }

    public function selected_p_ses(){
        return $this->hasMany(SelectedPS::class);
    }
    public function selected_m_o_o_es(){
        return $this->hasMany(SelectedMOOE::class);
    }
    public function selected_c_os(){
        return $this->hasMany(SelectedCO::class);
    }
}
