<?php

namespace App\Livewire\Forms;

use Exception;
use Livewire\Form;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\AuthorizationLevelService;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;

class LocalAccountForm extends Form {

    /** @var User $local_account */
    public User|null $local_account;

    public string|null $name;
    public string|null $username;
    public string|null $email;
    public string|null $password;
    public string|null $password_confirmation;
    public array $authorizations = [];
    public int $status_id = 1;

    public function delete_current_data() {
        $this->reset();
    }

    public $rules = [
        'username' => 'required|unique:App\Models\User,username',
        'password' => 'required|confirmed:password_confirmation',
    ];

    public $messages = [
        'username.required' => 'Felhasználónév megadása kötelező',
        'username.unique' => 'Felhasználónév már foglalt',
        'password.required' => 'Jelszó megadása kötelező',
        'password.confirmed' => 'A jelszavak nem egyeznek',
    ];

    public function rules() {
        return [
            'username' => [
                'required',
                Rule::unique('users', 'username')->ignore($this->local_account->id),
            ],
            'password' => 'nullable|confirmed',
        ];
    }

    public function messages() {
        return [
            'username.required' => 'Felhasználónév megadása kötelező',
            'username.unique' => 'Felhasználónév már foglalt',
            'password.confirmed' => 'A jelszavak nem egyeznek',
        ];
    }


    public function store() {
        $this->validate($this->rules, $this->messages);

        if (config('ldap.active')) {
            $user = LdapUser::where('samaccountname', '=', $this->username)->first();

            if ($user?->exists) {
                throw new Exception("Létezik ilyen felhasználónévvel LDAP felhasználó.");
            }
        }

        User::create([
            'name' => $this->name ?? $this->username,
            'username' => $this->username,
            'email' => $this->email ?? null,
            'password' => Hash::make($this->password),
            'auth_level' => AuthorizationLevelService::get_auth_level_by_names($this->get_active_auth_names()),
            'is_local' => true,
            'status_id' => $this->status_id
        ]);

        $this->reset();
    }

    public function set_local_account(int $local_account_id) {
        $this->reset('authorizations');

        $this->local_account = User::where('id',  $local_account_id)->first();

        $this->name =  $this->local_account->name;
        $this->username = $this->local_account->username;
        $this->email = $this->local_account->email;

        $user_auths = AuthorizationLevelService::get_auth_level_names($this->local_account);

        foreach ($user_auths as $user_auth) {
            $this->authorizations[$user_auth] = true;
        }

        $this->status_id = $this->local_account->status_id;
    }

    public function update() {
        $this->validate($this->rules(), $this->messages());

        $this->local_account->name = $this->name;
        $this->local_account->username = $this->username;
        $this->local_account->email = $this->email ?? null;

        if (isset($this->password))
            $this->local_account->password = Hash::make($this->password);

        $this->local_account->auth_level = AuthorizationLevelService::get_auth_level_by_names($this->get_active_auth_names());
        $this->local_account->status_id = $this->status_id;

        $this->local_account->save();

        if ($this->local_account->status_id == 2)
            DB::table('sessions')
                ->whereUserId($this->local_account->id)
                ->delete();
    }

    public function delete() {
        $delete_result = $this->local_account->delete();

        if (!isset($delete_result))
            throw new Exception('Törölni kívánt fiók nem található.');

        $this->reset('name', 'username', 'email');
    }

    public function get_active_auth_names() {
        $local_account_auth_names = [];
        foreach ($this->authorizations as $key => $value) {
            if ($value)
                array_push($local_account_auth_names, $key);
        }

        return $local_account_auth_names;
    }
}
