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
        $pSGroup->selected_p_ses->each(function ($selected_p_s) {
            $selected_p_s->delete();
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
