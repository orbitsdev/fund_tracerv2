<?php

namespace App\Models;

use App\Models\MOOEGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MOOEExpense extends Model
{
    use HasFactory;

    public function m_o_o_e_group(){
        return $this->belongsTo(MOOEGroup::class);
    }
}
