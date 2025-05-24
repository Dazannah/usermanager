<?php

use App\Settings\AppSettings;

if (!function_exists('app_settings')) {
  function app_settings() {
    return app(AppSettings::class);
  }
}
