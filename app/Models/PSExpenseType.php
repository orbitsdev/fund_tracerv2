<?php

namespace App\Models;

use App\Models\PSExpense;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PSExpenseType extends Model
{
    use HasFactory;

    public function ps_expense(){
        return $this->hasMany(PSExpense::class);
    }
}
