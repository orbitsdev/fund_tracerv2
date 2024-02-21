<?php

namespace App\Livewire;

use App\Models\Breakdown;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
class AttachmentView extends Component
{   

    public Breakdown $record;
    public function render()
    {
        return view('livewire.attachment-view');
    }
}
