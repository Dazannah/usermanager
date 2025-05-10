<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        Livewire::addPersistentMiddleware([
            \App\Http\Middleware\IsAdmin::class
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        //
    }
}
