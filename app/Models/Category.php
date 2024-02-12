<?php

namespace App\Models;

use App\Models\Particular;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    public function particular(): BelongsTo {
        return $this->belongsTo(Particular::class);
    }
}
