<?php

namespace App\Services;

class SanitizationService {

  public static function bool($value): bool {
    return boolval($value);
  }

  public static function email($value): string {
    return strtolower(trim($value));
  }

  public static function int($value): int {
    return intval($value);
  }

  public static function string($value) {
    return trim(strip_tags($value));
  }
}
