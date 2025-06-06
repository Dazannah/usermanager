<?php

namespace App\Livewire\Admin\Components;

use App\Livewire\Forms\AuthorizationForm;
use Exception;
use App\Models\Column;
use Livewire\Component;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class AuthorizationFormPanel extends Component {
    /** @var Collection<int,Status> $statuses */
    public Collection $statuses;

    /** @var Collection<int,Column> $columns */
    public Collection $columns;

    public AuthorizationForm $form;

    protected $listeners = ['update_authorization_form_panel', 'show_update_authorization', 'show_store_authorization'];

    public function mount() {
        $this->columns = Column::all_sorted_auth_items_by_position();
    }

    public function update_authorization_form_panel() {
        $this->mount();
    }

    public function show_update_authorization($authItem_id) {
        $this->form->set_authItem($authItem_id);
    }

    public function show_store_authorization() {
        $this->form->delete_current_data();
    }

    public function store_authorization() {
        try {
            $this->form->store();

            $this->dispatch('refresh_authorization_mount');
            $this->dispatch('authorization_save_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('authorization_error', $err->getMessage());

            $this->dispatch('refresh_authorization_mount');
        }
    }

    public function delete_authorization() {
        try {
            $this->form->delete();

            $this->dispatch('authorization_delete_success');
        } catch (QueryException $err) {
            $err_message = $err->getMessage();

            if ($err->getCode() == 23000) {
                $this->addError('authorization_error', "Nem lehet törölni ezt a jogosultságot, mert valószínűleg kapcsolódik más adatokhoz (pl. van aljogosultsága).");

                return;
            }

            $this->addError('authorization_error', "Ismeretlen hiba történt: $err_message");
        } catch (Exception $err) {
            $this->addError('authorization_error', $err->getMessage());
        } finally {
            $this->dispatch('refresh_authorization_mount');
        }
    }

    public function update_authorization() {
        try {
            $this->form->update();

            $this->dispatch('refresh_authorization_mount');
            $this->dispatch('authorization_save_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('authorization_error', $err->getMessage());

            $this->dispatch('refresh_authorization_mount');
        }
    }
}
