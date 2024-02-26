<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignedProject extends Model
{
    use HasFactory;


    public function assigned_projectable(): MorphTo
    {
        return $this->morphTo();
    }
    public function project(){
        return $this->belongsTo(Project::class);
    }
}
