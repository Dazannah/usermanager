<?php

namespace App\Livewire\Admin\Components;

use Exception;
use Livewire\Component;
use Illuminate\Database\QueryException;
use App\Livewire\Forms\SubAuthorizationForm;
use App\Models\AuthItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class SubAuthorizationFormPanel extends Component {
    /** @var Collection<int,Status> $statuses */
    public Collection $statuses;

    /** @var Collection<int,AuthItem> $authorizations */
    public Collection $authorizations;

    public SubAuthorizationForm $form;

    protected $listeners = ['update_sub_authorization_form_panel', 'show_update_sub_authorization', 'show_create_sub_authorization'];

    public function mount() {
        $this->authorizations = AuthItem::all();
    }

    public function update_sub_authorization_form_panel() {
        $this->mount();
    }

    public function show_update_sub_authorization($subAuthItem_id) {
        $this->form->set_subAuthItem($subAuthItem_id);
    }

    public function show_create_sub_authorization() {
        $this->form->delete_current_data();
    }

    public function store_sub_authorization_item() {
        try {
            $this->form->store();

            $this->dispatch('refresh_authorization_mount');
            $this->dispatch('save_sub_authorization_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('save_sub_authorization_error', $err->getMessage());

            $this->dispatch('refresh_authorization_mount');
        }
    }

    public function update_sub_authorization_item() {
        try {
            $this->form->update();

            $this->dispatch('save_edit_sub_authorization_success');
        } catch (Exception $err) {
            $this->addError('save_edit_sub_authorization_error', $err->getMessage());
        } finally {
            $this->dispatch('refresh_authorization_mount');
        }
    }

    public function delete_sub_authorization() {
        try {
            $this->form->delete();

            $this->dispatch('sub_authorization_delete_success');
        } catch (QueryException $err) {
            $err_message = $err->getMessage();

            if ($err->getCode() == 23000) {
                $this->addError('save_edit_authorization_error', "Nem lehet törölni ezt az aljogosultságot, mert valószínűleg kapcsolódik más adatokhoz.");

                return;
            }

            $this->addError('save_edit_authorization_error', "Ismeretlen hiba történt: $err_message");
        } catch (Exception $err) {
            $this->addError('save_edit_authorization_error', $err->getMessage());
        } finally {
            $this->dispatch('refresh_authorization_mount');
        }
    }
    public function render() {
        return view('livewire.admin.components.sub-authorization-form-panel');
    }
}
