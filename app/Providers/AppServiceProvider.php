<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\View\Components\Modal;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Model::unguard();

        FilamentColor::register([
            'primary' => "#0490b3c7",
            'system'=> [
                50=> '#ecfeff',
                100=> '#cefbff',
                200=> '#a3f4fe',
                300=> '#64eafc',
                400=> '#1dd5f3',
                500=> '#01b8d9',
                600=> '#0490b3c7',
                700=> '#135e77',
                800=> '#144f65',
                900=> '#073445',
            ],
            'trust'=> [
                50=> '#edf9ff',
                100=> '#d8f1ff',
                200=> '#b9e6ff',
                300=> '#89d8ff',
                400=> '#51c1ff',
                500=> '#29a3ff',
                600=> '#0980fe',
                700=> '#0b6bea',
                800=> '#1057bd',
                900=> '#112f5a',
            ],
        ]);

        Modal::closedByClickingAway(false);

    }
}
