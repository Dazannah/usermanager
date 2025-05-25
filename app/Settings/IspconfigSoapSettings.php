<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class IspconfigSoapSettings extends Settings {
    public bool $active;
    public string|null $uri;
    public string|null $location;
    public string|null $username;
    public string|null $password;

    public static function group(): string {
        return 'ispconfig_soap';
    }

    public static function encrypted(): array {
        return [
            'password'
        ];
    }
}
