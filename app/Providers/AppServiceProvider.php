<?php

namespace App\Providers;

use Livewire\Livewire;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        Livewire::addPersistentMiddleware([
            \App\Http\Middleware\IsSysAdmin::class
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        if (config('app.installed')) {
            $this->configure_mail();
        }
    }

    protected function configure_mail(): void {
        $mail_settings = mail_settings();
        $app_settings = app_settings();

        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.host' => $mail_settings->host,
            'mail.mailers.smtp.port' => $mail_settings->port,
            'mail.mailers.smtp.username' => $mail_settings->username,
            'mail.mailers.smtp.password' => $mail_settings->password,
            'mail.from.address' => $mail_settings->username,
            'mail.from.name' => $app_settings->app_name,
        ]);
    }
}
