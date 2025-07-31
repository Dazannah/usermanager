<?php

namespace App\Casts;

use App\Services\SanitizationService;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class SanitizedInt implements CastsAttributes {
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed {
        return $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed {
        if (is_numeric($value) && ctype_digit(strval($value)))
            return SanitizationService::int($value);

        throw new InvalidArgumentException("A(z) {$key} mező értéke érvénytelen egész szám: " . var_export($value, true));
    }
}
