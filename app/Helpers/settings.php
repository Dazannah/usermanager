<?php

use App\Settings\AppSettings;
use App\Settings\LdapSettings;
use App\Settings\MailSettings;

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

if (!function_exists('ldap_settings')) {
  function ldap_settings() {
    return app(LdapSettings::class);
  }
}
