<?php

namespace App\Providers;

use App\Models\File;
use App\Models\User;
use App\Models\PSGroup;
use App\Models\MOOEGroup;
use App\Models\ProjectYear;
use App\Observers\UserObserver;
use App\Observers\PSGroupObserver;
use App\Models\FinancialTransaction;
use App\Observers\FileObserver;
use App\Observers\MOOEGroupObserver;
use Illuminate\Support\Facades\Event;
use App\Observers\ProjectYearObserver;
use Illuminate\Auth\Events\Registered;
use App\Observers\FinancialTransactionObserver;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        PSGroup::observe(PSGroupObserver::class);
        MOOEGroup::observe(MOOEGroupObserver::class);
        ProjectYear::observe(ProjectYearObserver::class);
        FinancialTransaction::observe(FinancialTransactionObserver::class);
        File::observe(FileObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
