<?php

namespace App\Livewire\Admin\Components;

use Exception;
use Livewire\Component;
use Illuminate\Database\QueryException;
use App\Livewire\Forms\LocalAccountForm;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class LocalAccountFormPanel extends Component {
    /** @var Collection<int,Status> $accountAuthorizationLevels*/
    public Collection $accountAuthorizationLevels;

    /** @var Collection<int,Status> $statuses*/
    public Collection $statuses;

    /** @var LocalAccountForm $form */
    public LocalAccountForm $form;

    protected $listeners = ['edit_local_account_id', 'show_add_local_account'];

    public function edit_local_account_id($edit_local_account_id) {
        $this->form->set_local_account($edit_local_account_id);
    }

    public function show_add_local_account() {
        $this->form->delete_current_data();
    }

    public function create_local_account() {
        try {
            $this->form->store();

            $this->dispatch('refresh_local_accounts_mount');
            $this->dispatch('save_local_account_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('local_account_error', $err->getMessage());

            $this->dispatch('refresh_local_accounts_mount');
        }
    }

    public function update_local_account() {
        try {
            $this->form->update();

            $this->dispatch('save_local_account_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('local_account_error', $err->getMessage());
        } finally {
            $this->dispatch('refresh_local_accounts_mount');
        }
    }

    public function delete_edit_local_account() {
        try {
            $this->form->delete();

            $this->dispatch('edit_local_account_delete_success');
        } catch (QueryException $err) {
            $err_message = $err->getMessage();

            if ($err->getCode() == 23000) {
                $this->addError('local_account_error', "Nem lehet törölni ezt a helyi fiókot, mert valószínűleg kapcsolódik más adatokhoz.");

                return;
            }

            $this->addError('local_account_error', "Ismeretlen hiba történt: $err_message");
        } catch (Exception $err) {
            $this->addError('local_account_error', $err->getMessage());
        } finally {
            $this->dispatch('refresh_local_accounts_mount');
        }
    }

    public function render() {
        return view('livewire.admin.components.local-account-form-panel');
    }
}
