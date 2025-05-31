<?php

namespace App\Models;

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
        'technicalName' => 'string',
        'displayName' => 'string',
        'ldap_group_name' => 'string',
        'auth_level' => 'int'
    ];

    protected $fillable = [
        'technicalName',
        'displayName',
        'ldap_group_name',
        'auth_level'
    ];

    public function users() {
        return $this->hasMany(User::class, 'auth_level_id');
    }
}
