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
        $projectYear->selected_p_ses->each(function ($ps) {
            $ps->delete();
        });
        $projectYear->selected_m_o_o_es->each(function ($mooe) {
            $mooe->delete();
        });
        $projectYear->selected_c_os->each(function ($co) {
            $co->delete();
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
