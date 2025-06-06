<?php

namespace App\Services;

use App\Models\User;
use LdapRecord\Models\Model as LdapRecord;
use App\Models\AccountAuthorizationLevel;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;

class AuthorizationLevelService {

  public const AUTH_LEVELS = [
    'base' => 0b00001,
    'authorizer' => 0b00010,
    'reqAdmin' => 0b00100,
    'dlHandler' => 0b01000,
    'sysAdmin' => 0b10000,
  ];

  public static function get_sys_admin_level(): int {
    $user_level = 0;

    foreach (self::AUTH_LEVELS as $auth_level) {
      $user_level |= $auth_level;
    }

    return $user_level;
  }

  public static function hasLevel(User $user, int $level): bool {
    $user_auth_level = self::get_user_auth_level($user);

    return self::calculate_auth_bin($user_auth_level, $level);
  }

  public static function get_auth_level_by_names(array $auth_level_names): int {
    if (in_array('sysAdmin', $auth_level_names))
      return self::get_sys_admin_level();

    $auth_level = 0;

    foreach ($auth_level_names as $auth_level_name) {
      $auth_level |= self::AUTH_LEVELS[$auth_level_name];
    }

    return $auth_level;
  }

  // create new requests, search users and tickets
  public static function is_base(User $user): bool {
    return self::hasLevel($user, self::AUTH_LEVELS['base']);
  }

  // allow or deny requests
  public static function is_authorizer(User $user): bool {
    return self::hasLevel($user, self::AUTH_LEVELS['authorizer']);
  }

  // close requests
  public static function is_req_admin(User $user): bool {
    return self::hasLevel($user, self::AUTH_LEVELS['reqAdmin']);
  }

  // create, edit and delete distribution lists
  public static function is_dl_handler(User $user): bool {
    return self::hasLevel($user, self::AUTH_LEVELS['dlHandler']);
  }

  // access admin pages
  public static function is_sys_admin(User $user): bool {
    return self::hasLevel($user, self::AUTH_LEVELS['sysAdmin']);
  }

  public static function get_auth_level_displayNames(User $user): array {
    $accountAuthorizationLevels = AccountAuthorizationLevel::all();

    if (self::is_sys_admin($user))
      foreach ($accountAuthorizationLevels as $accountAuthorizationLevel) {
        if ($accountAuthorizationLevel->name === 'sysAdmin') {
          return [$accountAuthorizationLevel->displayName];
        }
      }

    $user_auth_level_names = [];

    $user_auth_level = self::get_user_auth_level($user);

    foreach (self::AUTH_LEVELS as $key => $auth_level) {
      if (($user_auth_level & $auth_level) == $auth_level) {
        foreach ($accountAuthorizationLevels as $accountAuthorizationLevel) {
          if ($accountAuthorizationLevel->name == $key)
            array_push($user_auth_level_names, $accountAuthorizationLevel->displayName);
        }
      }
    }

    return $user_auth_level_names;
  }

  public static function get_auth_level_names(User $user): array {
    $accountAuthorizationLevels = AccountAuthorizationLevel::all();

    if (self::is_sys_admin($user))
      foreach ($accountAuthorizationLevels as $accountAuthorizationLevel) {
        if ($accountAuthorizationLevel->name === 'sysAdmin') {
          return [$accountAuthorizationLevel->name];
        }
      }

    $user_auth_level_names = [];

    $user_auth_level = self::get_user_auth_level($user);

    foreach (self::AUTH_LEVELS as $key => $auth_level) {
      if (($user_auth_level & $auth_level) == $auth_level) {
        foreach ($accountAuthorizationLevels as $accountAuthorizationLevel) {
          if ($accountAuthorizationLevel->name == $key)
            array_push($user_auth_level_names, $accountAuthorizationLevel->name);
        }
      }
    }

    return $user_auth_level_names;
  }


  public static function get_user_auth_level(User $user): int {
    $user_auth_level = 0;

    if ($user->is_local) {
      $user_auth_level = $user->auth_level;
    } elseif (config('ldap.active')) {
      $user_auth_level = self::get_ldap_user_auth_level($user->username);
    }

    return $user_auth_level;
  }

  protected static function calculate_auth_bin($user_auth_level, $needed_level): bool {
    return ($user_auth_level & $needed_level) === $needed_level;
  }

  public static function get_ldap_user_auth_level($username, LdapRecord|null $user = null) {
    $user_auth_level = 0;

    $accountAuthorizationLevels = AccountAuthorizationLevel::all();

    if (!isset($user))
      $user = LdapUser::where('samaccountname', '=', $username)->first();

    $user_ldap_groups = $user->groups()->recursive()->get()->map(function ($group) {
      return $group->getName();
    })->all();

    foreach ($accountAuthorizationLevels as $accountAuthorizationLevel) {
      if (in_array($accountAuthorizationLevel->ldap_group_name, $user_ldap_groups))
        $user_auth_level |= self::AUTH_LEVELS[$accountAuthorizationLevel->name];
    }

    return $user_auth_level;
  }
}
