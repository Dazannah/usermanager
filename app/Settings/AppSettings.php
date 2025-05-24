<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AppSettings extends Settings {
    public string $app_name;
    public string|null $logo_name;

    public static function group(): string {
        return 'app';
    }
}
