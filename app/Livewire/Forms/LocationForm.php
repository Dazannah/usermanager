<?php

namespace App\Livewire\Forms;

use Exception;
use Livewire\Form;
use App\Models\Location;
use App\Models\Department;
use Illuminate\Validation\ValidationException;

class LocationForm extends Form {
    public Location|null $location;
    public string|null $displayName;
    public string|null $location_note = null;
    public int $status_id = 1;

    public $rules = [
        'displayName' => 'required',
        'status_id' => 'required'
    ];

    public $messages = [
        'displayName.required' => 'Elnevezés kitöltése kötelező',
        'status_id.required' => 'Egy státuszt ki kell választani'
    ];

    public function set_location($location_id): void {
        $this->location = Location::where('id', $location_id)->first();

        $this->displayName = $this->location->displayName;
        $this->status_id = $this->location->status_id;
        $this->location_note = $this->location->note;
    }

    public function update() {
        $this->validate();

        $this->location->displayName = $this->displayName;

        if ($this->location->status_id != $this->status_id) {
            if ($this->status_id == 2) {
                $departments = Department::where('location_id', "=", $this->location->id)->where('status_id', '=', 1)->get();

                if (count($departments) > 0)
                    throw ValidationException::withMessages([
                        'form.status_id' => ["A helyszín 1 vagy több aktív osztályhoz van rendelve."]
                    ]);
            }
        }

        $this->location->status_id = $this->status_id;
        $this->location->note = $this->location_note;

        $this->location->save();
    }

    public function delete() {
        $delete_result = $this->location->delete();

        if (!isset($delete_result))
            throw new Exception('Törölni kívánt oszlop nem található.');

        $this->reset('displayName', 'status_id', 'note');
    }

    public function store() {
        $this->validate();

        $location = new Location([
            'displayName' => $this->displayName,
            'status_id' => $this->status_id,
            'note' => empty($this->location_note) ? null : $this->location_note
        ]);

        $location->save();

        $this->reset();
    }
}
