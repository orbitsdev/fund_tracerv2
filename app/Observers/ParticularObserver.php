<?php

namespace App\Observers;

use App\Models\Particular;

class ParticularObserver
{
    /**
     * Handle the Particular "created" event.
     */
    public function created(Particular $particular): void
    {
        // $categoryData = [
        //     ['title' => 'Direct Cost'],
        //     ['title' => 'Category 2'],
        //     // Add more categories as needed
        // ];
        // $particular->categories()->createMany($categoryData);

    }

    /**
     * Handle the Particular "updated" event.
     */
    public function updated(Particular $particular): void
    {
        //
    }

    /**
     * Handle the Particular "deleted" event.
     */
    public function deleted(Particular $particular): void
    {
        //
    }

    /**
     * Handle the Particular "restored" event.
     */
    public function restored(Particular $particular): void
    {
        //
    }

    /**
     * Handle the Particular "force deleted" event.
     */
    public function forceDeleted(Particular $particular): void
    {
        //
    }
}
