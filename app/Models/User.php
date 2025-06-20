<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Exception;
use Illuminate\Notifications\Notifiable;
use LdapRecord\Laravel\Auth\HasLdapUser;

use App\Services\AuthorizationLevelService;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'auth_level',
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

    public function get_auth_level_displayNames() {
        $auth_level_names = AuthorizationLevelService::get_auth_level_displayNames($this);

        return $auth_level_names;
    }

    public function is_base(): bool {
        try {
            return AuthorizationLevelService::is_base($this);
        } catch (Exception $err) {
            session()->flash('error', $err->getMessage());

            return false;
        }
    }

    public function is_req_admin(): bool {
        try {
            return AuthorizationLevelService::is_req_admin($this);
        } catch (Exception $err) {
            session()->flash('error', $err->getMessage());

            return false;
        }
    }

    public function is_dl_handler(): bool {
        try {
            return AuthorizationLevelService::is_dl_handler($this);
        } catch (Exception $err) {
            session()->flash('error', $err->getMessage());

            return false;
        }
    }

    public function is_sys_admin(): bool {
        try {
            return AuthorizationLevelService::is_sys_admin($this);
        } catch (Exception $err) {
            session()->flash('error', $err->getMessage());

            return false;
        }
    }
}
