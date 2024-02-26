<?php

namespace App\Models;

use App\Models\Year;
use App\Models\Program;
use App\Models\ProjectYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }
    public function program(){
        return $this->belongsTo(Program::class);
    }

    public function project_years(){
        return $this->hasMany(ProjectYear::class);
    }

    public function assigned_project(){
        return $this->hasOne(AssignedProject::class);
    }





}
