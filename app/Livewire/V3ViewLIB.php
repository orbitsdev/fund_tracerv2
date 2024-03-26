<?php

namespace App\Livewire;

use App\Models\ProjectYear;
use Livewire\Component;

class V3ViewLIB extends Component
{

    public ProjectYear $record;
    public function render()
    {
        return view('livewire.v3-view-l-i-b');
    }
}
