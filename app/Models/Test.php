<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Test extends Model
{
    use HasFactory;

    public function testeable(): MorphTo
    {
        return $this->morphTo();
    }


    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

}
