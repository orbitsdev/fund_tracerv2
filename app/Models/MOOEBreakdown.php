<?php

namespace App\Models;

use App\Models\SelectedMOOE;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MOOEBreakdown extends Model
{
    use HasFactory;


    public function selected_m_o_o_e(){
        return $this->belongsTo(SelectedMOOE::class);
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }


}
