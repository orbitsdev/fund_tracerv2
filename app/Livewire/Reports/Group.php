<?php

namespace App\Livewire\Reports;

use App\Models\PSGroup;
use Livewire\Component;
use App\Models\MOOEGroup;
use App\Models\SelectedCO;
use App\Models\SelectedPS;
use App\Models\ProjectYear;
use App\Models\SelectedMOOE;

class Group extends Component
{

    public $record;
    public $type;
    public $year;
    public $yearContent;

    public function mount($record, $type, $year)

    {

        $this->year = $year;

        $this->yearContent = ProjectYear::find($this->year);

        switch ($type) {
            case 'ps':
                $this->record = PSGroup::find($record);

                break;
            case 'mooe':
                $this->record = MOOEGroup::find($record);
                // dd($this->record);
                break;
            case 'co':
                $this->record = SelectedCO::find($record);
                break;
            default:
                $this->record = [];
        }
    }


    public function render()
    {


        return view('livewire.reports.group');
    }
}
