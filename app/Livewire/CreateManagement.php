<?php

namespace App\Livewire;

use Livewire\Component;

class CreateManagement extends Component
{

    public function mount(){
        return redirect()->route('program.index');
    }
    public function render()
    {
        return view('livewire.create-management');
    }
}
