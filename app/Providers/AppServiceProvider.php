<?php

namespace App\Providers;

use App\Http\View\Composers\AdminLayoutComposer;
use App\Http\View\Composers\FrontLayoutComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('layouts.front', FrontLayoutComposer::class);
        View::composer('layouts.admin', AdminLayoutComposer::class);
    }
}
