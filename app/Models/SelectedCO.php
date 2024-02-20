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

}
