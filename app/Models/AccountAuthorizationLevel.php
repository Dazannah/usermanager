<?php

namespace App\Models;

use App\Casts\SanitizedInt;
use App\Casts\SanitizedString;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountAuthorizationLevel
 * 
 * @property int $id
 * @property string $displayName
 * @property int $auth_level
 *
 * @package App\Models
 */

class AccountAuthorizationLevel extends Model {
    protected $table = 'account_authorization_levels';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $casts = [
        'name' => SanitizedString::class,
        'displayName' => SanitizedString::class,
        'ldap_group_name' => SanitizedString::class,
        'auth_level' => SanitizedInt::class
    ];

    protected $fillable = [
        'name',
        'displayName',
        'ldap_group_name',
        'auth_level'
    ];

    public function users() {
        return $this->hasMany(User::class, 'auth_level_id');
    }
}
