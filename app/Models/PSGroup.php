<?php

namespace App\Models;

use App\Models\PSExpense;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PSGroup extends Model
{
    use HasFactory;
    public function p_s_expenses(){
        return $this->hasMany(PSExpense::class);
    }
}
