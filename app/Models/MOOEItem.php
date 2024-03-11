<?php

namespace App\Models;

use App\Models\MOOEExpenseSub;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MOOEItem extends Model
{
    use HasFactory;

    public function m_o_o_e_expense_sub(){
        return $this->belongsTo(MOOEExpenseSub::class);
    }

}
