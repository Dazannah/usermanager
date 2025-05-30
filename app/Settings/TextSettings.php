<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class TextSettings extends Settings {
    public string $departmentNumber;
    public string $departmentNumber2;

    public static function group(): string {
        return 'texts';
    }
}
