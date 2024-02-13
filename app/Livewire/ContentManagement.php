<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
class ContentManagement extends Component
{

    public $activeTab = 'personal';

    #[On('test')]
    public function test(){

    }

    public function mount(){
        return redirect()->route('personal-service.index');
    }

    public function render()
    {
        return view('livewire.content-management',[
            'activeTab' => $this->activeTab,
        ]);
    }
}
