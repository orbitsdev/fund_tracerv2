<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class AccountDetails extends Component
{   

    public User $record;
    public function render()
    {
        return view('livewire.account-details');
    }
}
