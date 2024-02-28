<?php

namespace App\Livewire\Reports;

use App\Models\PSGroup;
use Livewire\Component;
use App\Models\SelectedCO;
use App\Models\SelectedPS;
use App\Models\SelectedMOOE;

class Group extends Component
{

    public $record;
    public $type;
    public $year;

    public function mount($record, $type ,$year)

    {

        // dd($record, $type, $year);
        $this->year = $year;

        $this->record = PSGroup::whereHas('selected_p_ses', function ($query) use ($year) {
            $query->where('project_year_id', $year);
        })->find($record);



    }


    public function render()
    {


        return view('livewire.reports.group');
    }
}
