<?php

namespace App\Livewire\Setup\Components;

use App\Livewire\Forms\AccountAuthorizationLevelForm;
use Exception;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class AccountAuthorizationLevelsFormPanel extends Component {

    public AccountAuthorizationLevelForm $form;

    public $listeners = ['show_update_account_authorization'];

    public function show_update_account_authorization($update_account_authorization_id) {
        $this->form->set_account_authorization_level($update_account_authorization_id);
    }

    public function update_account_authorization() {
        try {
            $this->form->update();

            $this->dispatch('update_account_authorization_success');
            $this->dispatch('refresh_authorizations_levels_mount');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('account_authorization_error', $err->getMessage());
        }
    }


    public function render() {
        return view('livewire.setup.components.account-authorization-levels-form-panel');
    }
}
