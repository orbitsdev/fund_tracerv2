<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
class ForbiddenPage extends Component
{

    #[Layout('components.no-layout')]
    public function render()
    {
        return view('livewire.forbidden-page');
    }
}
