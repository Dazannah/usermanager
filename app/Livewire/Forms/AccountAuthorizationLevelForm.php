<?php

namespace App\Livewire\Forms;

use App\Models\AccountAuthorizationLevel;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AccountAuthorizationLevelForm extends Form {
    public AccountAuthorizationLevel $accountAuthorizationLevel;

    public string|null $displayName;
    public string|null $ldap_group_name;
    public string|null $name;

    public $rules = [
        'displayName' => 'required',
        'ldap_group_name' => 'required'
    ];

    public $messages = [
        'displayName.required' => 'Mejelenítési név megadása kötelező.',
        'ldap_group_name' => 'LDAP csoport név megadása kötelező.'
    ];

    public function set_account_authorization_level($update_account_authorization_id) {
        $this->accountAuthorizationLevel = AccountAuthorizationLevel::where('id', $update_account_authorization_id)->first();

        $this->displayName = $this->accountAuthorizationLevel->displayName;
        $this->ldap_group_name = $this->accountAuthorizationLevel->ldap_group_name;
        $this->name = $this->accountAuthorizationLevel->name;
    }

    public function update() {
        $this->validate();

        $this->accountAuthorizationLevel->displayName =  $this->displayName;
        $this->accountAuthorizationLevel->ldap_group_name = $this->ldap_group_name;

        $this->accountAuthorizationLevel->save();
    }
}
