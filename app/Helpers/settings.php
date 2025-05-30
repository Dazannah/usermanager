<?php

use App\Settings\AppSettings;
use App\Settings\MailSettings;
use App\Settings\TextSettings;
use App\Settings\IspconfigSoapSettings;

if (!function_exists('app_settings')) {
  function app_settings() {
    return app(AppSettings::class);
  }
}

if (!function_exists('mail_settings')) {
  function mail_settings() {
    return app(MailSettings::class);
  }
}

if (!function_exists('ispconfig_soap_settings')) {
  function ispconfig_soap_settings() {
    return app(IspconfigSoapSettings::class);
  }
}

if (!function_exists('texts_settings')) {
  function texts_settings() {
    return app(TextSettings::class);
  }
}
