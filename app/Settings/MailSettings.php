<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class MailSettings extends Settings {
    public string|null $host;
    public int|null $port;
    public string|null $username;
    public string|null $password;

    public static function group(): string {
        return 'mail';
    }

    public static function encrypted(): array {
        return [
            'password'
        ];
    }
}
