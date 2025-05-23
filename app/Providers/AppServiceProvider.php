<?php

namespace App\Providers;

use App\Models\Config;
use Livewire\Livewire;
use Illuminate\Support\ServiceProvider;

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
        $configs = Config::all();

        foreach ($configs as $config) {
            config(["$config->name" => $config->value]);
        }
    }
}
