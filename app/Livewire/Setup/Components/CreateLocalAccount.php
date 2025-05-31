<?php

namespace App\Livewire\Setup\Components;

use Exception;
use App\Models\User;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class CreateLocalAccount extends Component {
    /** @var Collection<int,Status> $accountAuthorizationLevels*/
    public Collection $accountAuthorizationLevels;


    // livewire view properties
    public string|null $create_local_account_name;
    public string $create_local_account_username;
    public string|null $create_local_account_email;
    public string $create_local_account_password;
    public string $create_local_account_password_confirmation;
    public int $create_local_account_authorization_level = 1;

    public $rules = [
        'create_local_account_username' => 'required|unique:App\Models\User,username',
        'create_local_account_password' => 'required|confirmed:create_local_account_password_confirmation',
        'create_local_account_authorization_level' => 'required|exists:App\Models\AccountAuthorizationLevel,id',
    ];

    public $messages = [
        'create_local_account_username.required' => 'Felhasználónév megadása kötelező',
        'create_local_account_username.unique' => 'Felhasználónév már foglalt',
        'create_local_account_password.required' => 'Jelszó megadása kötelező',
        'create_local_account_password.confirmed' => 'A jelszavak nem egyeznek',
        'create_local_account_authorization_level.required' => 'Jogosultsági szint megadása kötelező',
        'create_local_account_authorization_level.exists' => 'Ez az azonosító nem létezik',
    ];

    public function save_local_account() {
        try {
            $this->validate($this->rules, $this->messages);

            if (config('ldap.active')) {
                $user = LdapUser::where('samaccountname', '=', $this->create_local_account_username)->first();

                if ($user?->exists) {
                    throw new Exception("Létezik ilyen felhasználónévvel LDAP felhasználó.");
                }
            }

            User::create([
                'name' => $this->create_local_account_name ?? $this->create_local_account_username,
                'username' => $this->create_local_account_username,
                'email' => $this->create_local_account_email ?? null,
                'password' => Hash::make($this->create_local_account_password),
                'auth_level_id' => $this->create_local_account_authorization_level,
                'is_local' => true
            ]);

            $this->reset('create_local_account_name', 'create_local_account_username', 'create_local_account_email', 'create_local_account_password', 'create_local_account_password_confirmation', 'create_local_account_authorization_level');
            $this->dispatch('refresh_local_accounts_mount');
            $this->dispatch('save_local_account_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('save_local_account_error', $err->getMessage());

            $this->dispatch('refresh_local_accounts_mount');
        }
    }

    public function render() {
        return view('livewire.setup.components.create-local-account');
    }
}
