<?php

namespace App\Models;

use App\Models\MOOEExpense;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MOOEExpenseSub extends Model
{
    use HasFactory;


    public function m_o_o_e_expense(){
        return $this->belongsTo(MOOEExpense::class);
    }
}
