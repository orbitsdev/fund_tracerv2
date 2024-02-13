<?php

namespace App\Observers;

use App\Models\PSGroup;

class PSGroupObserver
{
    /**
     * Handle the PSGroup "created" event.
     */
    public function created(PSGroup $pSGroup): void
    {
        //
    }

    /**
     * Handle the PSGroup "updated" event.
     */
    public function updated(PSGroup $pSGroup): void
    {
        //
    }

    /**
     * Handle the PSGroup "deleted" event.
     */
    public function deleted(PSGroup $pSGroup): void
    {
        $pSGroup->p_s_expenses->each(function ($p_s_expense) {
            $p_s_expense->delete();
        });
    }

    /**
     * Handle the PSGroup "restored" event.
     */
    public function restored(PSGroup $pSGroup): void
    {
        //
    }

    /**
     * Handle the PSGroup "force deleted" event.
     */
    public function forceDeleted(PSGroup $pSGroup): void
    {
        //
    }
}
