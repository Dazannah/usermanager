<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class LdapSettings extends Settings {
    public bool $active;
    public string|null $host;
    public string|null $base_dn;
    public string|null $port;
    public string|null $username;
    public string|null $password;

    public static function group(): string {
        return 'ldap';
    }

    public static function encrypted(): array {
        return [
            'password'
        ];
    }
}
