<?php

namespace App\Models;

use App\Models\MOOEExpense;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MOOEGroup extends Model
{
    use HasFactory;
    public function m_o_o_e_expenses(){
        return $this->hasMany(MOOEExpense::class);
    }
}
