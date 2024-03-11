<?php

namespace App\Models;

use App\Models\PSGroup;
use App\Models\PSExpenseType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PSExpense extends Model
{
    use HasFactory;

    public function p_s_group(){
        return $this->belongsTo(PSGroup::class);
    }
    public function p_s_expense_type(){
        return $this->belongsTo(PSExpenseType::class);
    }
}
