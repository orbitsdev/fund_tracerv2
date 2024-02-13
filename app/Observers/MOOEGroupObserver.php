<?php

namespace App\Observers;

use App\Models\MOOEGroup;

class MOOEGroupObserver
{
    /**
     * Handle the MOOEGroup "created" event.
     */
    public function created(MOOEGroup $mOOEGroup): void
    {
        //
    }

    /**
     * Handle the MOOEGroup "updated" event.
     */
    public function updated(MOOEGroup $mOOEGroup): void
    {
        //
    }

    /**
     * Handle the MOOEGroup "deleted" event.
     */
    public function deleted(MOOEGroup $mOOEGroup): void
    {
        $mOOEGroup->m_o_o_e_expenses->each(function ($m_o_o_e_expense) {
            $m_o_o_e_expense->delete();
        });
    }

    /**
     * Handle the MOOEGroup "restored" event.
     */
    public function restored(MOOEGroup $mOOEGroup): void
    {
        //
    }

    /**
     * Handle the MOOEGroup "force deleted" event.
     */
    public function forceDeleted(MOOEGroup $mOOEGroup): void
    {
        //
    }
}
