<?php

namespace App\Ldap\Rules;

use LdapRecord\Laravel\Auth\Rule;
use LdapRecord\Models\Model as LdapRecord;
use LdapRecord\Models\ActiveDirectory\Group;
use Illuminate\Database\Eloquent\Model as Eloquent;

class CanLogin implements Rule {
    /**
     * Check if the rule passes validation.
     */
    public function passes(LdapRecord $user, Eloquent $model = null): bool { // make it configurable
        $base_auths = Group::where('cn', '=', 'JogosultsagigenyAlap')->first();
        $permission_auths = Group::where('cn', '=', 'JogosultsagigenyEngedelyezok')->first();
        $distribution_list_auths = Group::where('cn', '=', 'JogosultsagigenyTerjesztesilista')->first();
        $admin_auths = Group::where('cn', '=', 'JogosultsagigenyAdminisztrator')->first();

        $result = $user->groups()->recursive()->exists($base_auths) || $user->groups()->recursive()->exists($permission_auths) || $user->groups()->recursive()->exists($distribution_list_auths) || $user->groups()->recursive()->exists($admin_auths);
        return $result;
    }
}
