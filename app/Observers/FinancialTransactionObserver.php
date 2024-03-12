<?php

namespace App\Observers;

use App\Models\FinancialTransaction;

class FinancialTransactionObserver
{
    /**
     * Handle the FinancialTransaction "created" event.
     */
    public function created(FinancialTransaction $financialTransaction): void
    {
        //
    }

    /**
     * Handle the FinancialTransaction "updated" event.
     */
    public function updated(FinancialTransaction $financialTransaction): void
    {
        //
    }

    /**
     * Handle the FinancialTransaction "deleted" event.
     */
    public function deleted(FinancialTransaction $financialTransaction): void
    {
        $financialTransaction->files->each(function($item){
            $item->delete();
        });
    }

    /**
     * Handle the FinancialTransaction "restored" event.
     */
    public function restored(FinancialTransaction $financialTransaction): void
    {
        //
    }

    /**
     * Handle the FinancialTransaction "force deleted" event.
     */
    public function forceDeleted(FinancialTransaction $financialTransaction): void
    {
        //
    }
}
