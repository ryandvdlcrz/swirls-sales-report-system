<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;

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
        //FilamentView::registerRenderHook(
        //    'panels::body.start',
        //    fn(): string => Blade::render('<style>
        //    body {
        //        background-image: url("{{ asset(\'img/home.png\') }}");
        //        background-size: cover;
        //        background-position: center;
        //        background-attachment: fixed;
        //    }
        //</style>')
        //);
    }
}
