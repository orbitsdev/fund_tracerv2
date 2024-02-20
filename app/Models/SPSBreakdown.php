<?php

namespace App\Models;

use App\Models\SelectedPS;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SPSBreakdown extends Model
{
    use HasFactory;

    public function selected_p_s(){
        return $this->belongsTo(SelectedPS::class);
    }


    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
