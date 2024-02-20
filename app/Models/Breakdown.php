<?php

namespace App\Models;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Breakdown extends Model
{
    use HasFactory;

    public function breakdownable(): MorphTo
    {
        return $this->morphTo();
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

}
