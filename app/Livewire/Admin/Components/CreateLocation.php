<?php

namespace App\Livewire\Admin\Components;

use App\Models\Location;
use Exception;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class CreateLocation extends Component {
    /** @var Status $status */
    public Collection $statuses;

    //create properties
    public $create_location_displayName, $create_location_note;
    public $create_location_status_id = 1;

    //create new
    public function save_new_location() {
        try {
            //validation rules
            $rules = [
                'create_location_displayName' => 'required',
                'create_location_status_id' => 'required'
            ];

            //vatidation messages
            $messages = [
                'create_location_displayName.required' => 'Elnevezés kitöltése kötelező',
                'create_location_status_id.required' => 'Egy státuszt ki kell választani'
            ];

            $this->validate($rules, $messages);

            //create and save location

            $location = new Location([
                'displayName' => $this->create_location_displayName,
                'status_id' => $this->create_location_status_id,
                'note' => empty($this->create_location_note) ? null : $this->create_location_note
            ]);

            $location->save();

            //message and update $locations
            $this->reset('create_location_displayName', 'create_location_note');

            $this->dispatch('save_new_location_success');
            $this->dispatch('refresh_locations_mount');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('save_new_location_error', $err->getMessage());

            $this->dispatch('refresh_locations_mount');
        }
    }

    public function render() {
        return view('livewire.admin.components.create-location');
    }
}
