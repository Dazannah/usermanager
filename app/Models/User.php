<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Exception;
use Illuminate\Notifications\Notifiable;
use LdapRecord\Laravel\Auth\HasLdapUser;

use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;

class User extends Authenticatable implements LdapAuthenticatable {
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, AuthenticatesWithLdap, HasLdapUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'is_admin',
        'is_local',
        'status_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function status() {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function is_admin(): bool {
        try {
            if ($this->is_admin)
                return true;

            if (config('ldap.active')) {
                $user = LdapUser::where('samaccountname', '=', $this->username)->first();

                $user_ldap_groups = $user->groups()->recursive()->get()->map(function ($group) {
                    return $group->getName();
                })->all();

                $admin_ldap_groups = config('auth.admin_ldap_groups');

                foreach ($user_ldap_groups as $user_ldap_group) {
                    if (in_array($user_ldap_group, $admin_ldap_groups))
                        return true;
                }
            }

            return false;
        } catch (Exception $err) {
            session()->flash('error', $err->getMessage());

            return false;
        }
    }
}
