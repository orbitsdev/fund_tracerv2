<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\SelectedCO;
use App\Models\SelectedPS;
use App\Models\SelectedMOOE;

class Breakdown extends Component
{

    public $data;
    public $type;
    public $selected;

    public function mount($record, $type) {
        // dd($data, $type);
        switch ($type) {
            case 'ps':
                $this->data = SelectedPS::find($record);
                $this->selected = $this->data->p_s_expense->title;
                break;
            case 'mooe':
                $this->data = SelectedMOOE::find($record);
                $this->selected = $this->data->m_o_o_e_expense->title;
                break;
            case 'co':
                $this->data = SelectedCO::find($record);
                $this->selected = $this->data->description;
                break;
            default:
                $this->data = [];
                $this->selected = '';
                // Default case logic
        }
    }
    
    public function render()
    {
        return view('livewire.reports.breakdown',[]);
    }
}
