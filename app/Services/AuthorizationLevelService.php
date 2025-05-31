<?php

namespace App\Services;

use App\Models\User;
use App\Models\AccountAuthorizationLevel;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;

class AuthorizationLevelService {
  public const BASE = 0b00001;
  public const BASE_LDAP = 'base';
  public const AUTHORIZER = 0b00010;
  public const AUTHORIZER_LDAP = 'authorizer';
  public const REQ_ADMIN = 0b00100;
  public const REQ_ADMIN_LDAP = 'reqAdmin';
  public const DL_HANDLER = 0b01000;
  public const DL_HANDLER_LDAP = 'dlHandler';
  public const SYS_ADMIN = 0b10000;
  public const SYS_ADMIN_LDAP = 'sysAdmin';

  public static function hasLevel(User $user, int $level, string $ldapName): bool {
    if ($user->is_local) {
      return self::calculate_auth_bin($user->auth_level->auth_level, $level);
    }

    if (config('ldap.active')) {
      return self::is_ldap_have_auth($ldapName, $user->username);
    }

    return false;
  }

  // create new requests, search users and tickets
  public static function is_base(User $user): bool {
    return self::hasLevel($user, self::BASE, self::BASE_LDAP);
  }

  // allow or deny requests
  public static function is_authorizer(User $user): bool {
    return self::hasLevel($user, self::AUTHORIZER, self::AUTHORIZER_LDAP);
  }

  // close requests
  public static function is_req_admin(User $user): bool {
    return self::hasLevel($user, self::REQ_ADMIN, self::REQ_ADMIN_LDAP);
  }

  // create, edit and delete distribution lists
  public static function is_dl_handler(User $user): bool {
    return self::hasLevel($user, self::DL_HANDLER, self::DL_HANDLER_LDAP);
  }

  // access admin pages
  public static function is_sys_admin(User $user): bool {
    return self::hasLevel($user, self::SYS_ADMIN, self::SYS_ADMIN_LDAP);
  }

  protected static function calculate_auth_bin($user_auth_level, $needed_level) {
    return ($user_auth_level & $needed_level) === $needed_level;
  }

  protected static function is_ldap_have_auth($needed_level, $username) {
    $accountAuthorizationLevelAdmin = AccountAuthorizationLevel::where('technicalName', $needed_level)->firstOrFail();

    $user = LdapUser::where('samaccountname', '=', $username)->first();

    $user_ldap_groups = $user->groups()->recursive()->get()->map(function ($group) {
      return $group->getName();
    })->all();

    foreach ($user_ldap_groups as $user_ldap_group) {
      if ($user_ldap_group === $accountAuthorizationLevelAdmin->ldap_group_name)
        return true;
    }

    return false;
  }
}
