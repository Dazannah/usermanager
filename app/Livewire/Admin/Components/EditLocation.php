<?php

namespace App\Livewire\Admin\Components;

use Exception;
use App\Models\Status;
use Livewire\Component;
use App\Models\Location;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class EditLocation extends Component {

    /** @var Collection<int,Status> $statuses */
    public Collection $statuses;

    // livewire view properties
    public Location $edit_location;
    public string $edit_location_displayName, $edit_location_note;
    public int $edit_location_status_id;

    protected $listeners = ['show_edit_location_id'];

    public function show_edit_location_id($edit_location_id) {
        $this->edit_location = Location::where('id', $edit_location_id)->first();

        $this->edit_location_displayName = $this->edit_location->displayName;
        $this->edit_location_status_id = $this->edit_location->status_id;
        $this->edit_location_note = $this->edit_location->note;
    }

    //edit save

    public function save_edit_location() {
        try {
            //validation rules
            $rules = [
                'edit_location_displayName' => 'required',
                'edit_location_status_id' => 'required'
            ];

            //vatidation messages
            $messages = [
                'edit_location_displayName.required' => 'Elnevezés kitöltése kötelező',
                'edit_location_status_id.required' => 'Egy státuszt ki kell választani'
            ];

            $this->validate($rules, $messages);

            $this->edit_location->displayName = $this->edit_location_displayName;
            $this->edit_location->status_id = $this->edit_location_status_id;
            $this->edit_location->note = $this->edit_location_note;

            $this->edit_location->save();

            $this->dispatch('save_edit_location_success');
            $this->dispatch('refresh_locations_mount');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('save_edit_location_error', $err->getMessage());

            $this->dispatch('refresh_locations_mount');
        }
    }

    //delete

    public function delete_edit_location() {
        try {
            $delete_result = $this->edit_location->delete();

            if (!isset($delete_result))
                throw new Exception('Törölni kívánt oszlop nem található.');

            $this->reset('edit_location_displayName', 'edit_location_status_id', 'edit_location_note');

            $this->dispatch('save_edit_location_success');
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


    public function render() {
        return view('livewire.admin.components.edit-location');
    }
}
