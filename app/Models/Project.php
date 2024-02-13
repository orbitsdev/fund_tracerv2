<?php

namespace App\Models;

use App\Models\Program;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
    public function program(){
        return $this->belongsTo(Program::class);
    }
}
