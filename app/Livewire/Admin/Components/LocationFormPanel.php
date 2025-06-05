<?php

namespace App\Livewire\Admin\Components;

use App\Livewire\Forms\LocationForm;
use Exception;
use Livewire\Component;
use App\Models\Location;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class LocationFormPanel extends Component {
    /** @var Collection<int,Status> $statuses */
    public Collection $statuses;

    public LocationForm $form;

    protected $listeners = ['update_location_id'];

    public function update_location_id($location_id) {
        $this->form->set_location($location_id);
    }

    public function show_add_location() {
        $this->form->delete_current_data();
    }

    //edit save

    public function update_location() {
        try {
            $this->form->update();

            $this->dispatch('location_success');
            $this->dispatch('refresh_locations_mount');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('save_edit_location_error', $err->getMessage());

            $this->dispatch('refresh_locations_mount');
        }
    }

    //delete

    public function delete_location() {
        try {
            $this->form->delete();

            $this->dispatch('save_delete_location_success');
        } catch (QueryException $err) {
            $err_message = $err->getMessage();

            if ($err->getCode() == 23000) {
                $this->addError('save_edit_location_error', "Nem lehet törölni ezt a helyszínt, mert valószínűleg kapcsolódik más adatokhoz (pl. egy osztályhoz).");

                return;
            }

            $this->addError('save_edit_location_error', "Ismeretlen hiba történt: $err_message");
        } catch (Exception $err) {
            $this->addError('save_edit_location_error', $err->getMessage());
        } finally {
            $this->dispatch('refresh_locations_mount');
        }
    }

    public function create_location() {
        try {
            $this->form->store();

            $this->dispatch('location_success');
            $this->dispatch('refresh_locations_mount');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('save_new_location_error', $err->getMessage());

            $this->dispatch('refresh_locations_mount');
        }
    }

    public function render() {
        return view('livewire.admin.components.location-form-panel');
    }
}
