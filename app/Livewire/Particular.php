<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Particular extends Component
{
    public function render()
    {
        return view('livewire.particular');
    }

    public function categories() : HasMany{
        return $this->hasMany(Category::class);
    }
}
