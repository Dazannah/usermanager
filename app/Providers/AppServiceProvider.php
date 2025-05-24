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
            \App\Http\Middleware\IsAdmin::class
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        if (config('app.installed')) {
            $this->configure_mail();

            if (ldap_settings()->active)
                $this->configure_ldap();
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

    protected function configure_ldap() {
        $ldap_settings = ldap_settings();

        config([
            'ldap.connections.default.hosts' => $ldap_settings->host,
            'ldap.connections.default.port' => $ldap_settings->port,
            'ldap.connections.default.base_dn' => $ldap_settings->base_dn,
            'ldap.connections.default.username' => $ldap_settings->username,
            'ldap.connections.default.password' => $ldap_settings->password
        ]);
    }
}
