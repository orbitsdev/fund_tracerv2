<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\ProjectYear;

class YearParticularReport extends Component
{

    public  $record;
    public $type;

    public function mount($record, $type) {
        $this->record = ProjectYear::find($record);
        $this->type = $type;
    }
    public function render()
    {
        return view('livewire.reports.year-particular-report');
    }
}
