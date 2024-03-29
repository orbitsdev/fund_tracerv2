<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        Gate::define('is-admin', function () {

            return Auth::user()->role === 'Admin';
         });

        Gate::define('is-financial-manager', function () {
            return Auth::user()->role === 'Financial Manager';
         });
        Gate::define('admin-and-has-project-financial-manager', function () {
            $user = Auth::user();
            return($user->role === 'Admin'|| ($user->role === 'Financial Manager' && $user->assigned_project()->exists())  );
         });



    }
}
