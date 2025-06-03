<?php

namespace App\Livewire\Setup\Components;

use Exception;
use App\Models\User;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use App\Services\AuthorizationLevelService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class EditLocalAccount extends Component {
    /** @var Collection<int,Status> $accountAuthorizationLevels*/
    public Collection $accountAuthorizationLevels;

    // livewire view properties
    /** @var User $edit_local_account */
    public User $edit_local_account;
    public string|null $edit_local_account_name;
    public string $edit_local_account_username;
    public string|null $edit_local_account_email;
    public string|null $edit_local_account_password;
    public string|null $edit_local_account_password_confirmation;
    public array $edit_local_account_authorizations = [];

    public function rules() {
        return [
            'edit_local_account_username' => [
                'required',
                Rule::unique('users', 'username')->ignore($this->edit_local_account->id),
            ],
            'edit_local_account_password' => 'nullable|confirmed',
        ];
    }

    public $messages = [
        'edit_local_account_username.required' => 'Felhasználónév megadása kötelező',
        'edit_local_account_username.unique' => 'Felhasználónév már foglalt',
        'edit_local_account_password.confirmed' => 'A jelszavak nem egyeznek',
    ];

    protected $listeners = ['edit_local_account_id'];

    public function edit_local_account_id($edit_local_account_id) {
        $this->reset('edit_local_account_authorizations');

        $this->edit_local_account = User::where('id',  $edit_local_account_id)->first();

        $this->edit_local_account_name =  $this->edit_local_account->name;
        $this->edit_local_account_username = $this->edit_local_account->username;
        $this->edit_local_account_email = $this->edit_local_account->email;

        $user_auths = AuthorizationLevelService::get_auth_level_names($this->edit_local_account);

        foreach ($user_auths as $user_auth) {
            $this->edit_local_account_authorizations[$user_auth] = true;
        }
    }

    public function save_local_account() {
        try {
            $this->validate($this->rules(), $this->messages);

            $local_account_auth_names = [];
            foreach ($this->edit_local_account_authorizations as $key => $value) {
                if ($value)
                    array_push($local_account_auth_names, $key);
            }

            $this->edit_local_account->name = $this->edit_local_account_name;
            $this->edit_local_account->username = $this->edit_local_account_username;
            $this->edit_local_account->email = $this->edit_local_account_email ?? null;

            if (isset($this->edit_local_account_password))
                $this->edit_local_account->password = Hash::make($this->edit_local_account_password);

            $this->edit_local_account->auth_level = AuthorizationLevelService::get_auth_level_by_names($local_account_auth_names);

            $this->edit_local_account->save();

            $this->dispatch('save_local_account_success');
            $this->dispatch('save_local_account_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('save_edit_local_account_error', $err->getMessage());
        } finally {
            $this->dispatch('refresh_local_accounts_mount');
        }
    }

    public function delete_edit_local_account() {
        try {
            $delete_result = $this->edit_local_account->delete();

            if (!isset($delete_result))
                throw new Exception('Törölni kívánt fiók nem található.');

            $this->reset('edit_local_account_name', 'edit_local_account_username', 'edit_local_account_email');

            $this->dispatch('edit_local_account_delete_success');
        } catch (QueryException $err) {
            $err_message = $err->getMessage();

            if ($err->getCode() == 23000) {
                $this->addError('delete_edit_local_account', "Nem lehet törölni ezt a helyi fiókot, mert valószínűleg kapcsolódik más adatokhoz.");

                return;
            }

            $this->addError('delete_edit_local_account', "Ismeretlen hiba történt: $err_message");
        } catch (Exception $err) {
            $this->addError('delete_edit_local_account', $err->getMessage());
        } finally {
            $this->dispatch('refresh_local_accounts_mount');
        }
    }

    public function render() {
        return view('livewire.setup.components.edit-local-account');
    }
}
