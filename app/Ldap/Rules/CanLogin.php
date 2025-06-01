<?php

namespace App\Ldap\Rules;

use LdapRecord\Laravel\Auth\Rule;
use LdapRecord\Models\Model as LdapRecord;
use App\Services\AuthorizationLevelService;
use LdapRecord\Models\ActiveDirectory\Group;
use Illuminate\Database\Eloquent\Model as Eloquent;

class CanLogin implements Rule {
    /**
     * Check if the rule passes validation.
     */
    public function passes(LdapRecord $user, Eloquent|null $model = null): bool { // make it configurable
        $user_auth_level = AuthorizationLevelService::get_ldap_user_auth_level($model->username, $user);

        return $user_auth_level  > 0;
    }
}
