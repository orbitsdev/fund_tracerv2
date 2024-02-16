<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProjectYear;

class ViewProjectYearBudget extends Component
{

    public ProjectYear $record;
    public function render()
    {
        return view('livewire.view-project-year-budget');
    }
}
