<?php

namespace App\Observers;

use App\Models\ProjectYear;

class ProjectYearObserver
{
    /**
     * Handle the ProjectYear "created" event.
     */
    public function created(ProjectYear $projectYear): void
    {
        //
    }

    /**
     * Handle the ProjectYear "updated" event.
     */
    public function updated(ProjectYear $projectYear): void
    {
        //
    }

    /**
     * Handle the ProjectYear "deleted" event.
     */
    public function deleted(ProjectYear $projectYear): void
    {
        $projectYear->p_s_expenses->each(function ($p_s_expense) {
            $p_s_expense->delete();
        });
        $projectYear->p_s_expenses->each(function ($p_s_expense) {
            $p_s_expense->delete();
        });
    }

    /**
     * Handle the ProjectYear "restored" event.
     */
    public function restored(ProjectYear $projectYear): void
    {
        //
    }

    /**
     * Handle the ProjectYear "force deleted" event.
     */
    public function forceDeleted(ProjectYear $projectYear): void
    {
        //
    }
}
