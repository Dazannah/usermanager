<?php

namespace App\Livewire\Forms;

use Exception;
use Livewire\Form;
use App\Models\Department;
use Livewire\Attributes\Validate;

class DepartmentForm extends Form {
    public Department|null $department;

    // livewire view properties
    public string|null $displayName;
    public string|null $manager = null;
    public string|null $departmentNumber = null;
    public string|null $departmentNumber2 = null;
    public int $status_id = 1;
    public int|null $location_id;

    public $rules = [
        'displayName' => 'required',
        'status_id' => 'required|exists:App\Models\Status,id',
        'location_id' => 'required|exists:App\Models\Location,id'
    ];

    public $messages = [
        'displayName.required' => 'Elnevezés megadása kötelező',
        'status_id.required' => 'Státusz kiválasztása kötelező',
        'status_id.exists' => 'Kiválasztott státusz nem létezik.',
        'location_id.required' => 'Helyszín kiválasztása kötelező',
        'location_id.exists' => 'Kiválasztott helyszín nem létezik.',
    ];


    public function set_department($department_id) {
        $this->department = Department::where('id', $department_id)->first();

        $this->displayName = $this->department->displayName;
        $this->manager = $this->department->manager;
        $this->departmentNumber = $this->department->departmentNumber;
        $this->departmentNumber2 = $this->department->departmentNumber2;
        $this->status_id = $this->department->status_id;
        $this->location_id = $this->department->location_id;
    }

    public function delete_current_data() {
        $this->reset();
    }

    public function update() {
        $this->validate();

        $this->department->displayName = $this->displayName;
        $this->department->manager = $this->manager;
        $this->department->departmentNumber = $this->departmentNumber;
        $this->department->departmentNumber2 = $this->departmentNumber2;
        $this->department->status_id = $this->status_id;
        $this->department->location_id = $this->location_id;

        $this->department->save();
    }

    public function delete() {
        $delete_result = $this->department->delete();

        if (!isset($delete_result))
            throw new Exception('Törölni kívánt osztály nem található.');

        $this->reset();
    }

    public function store() {
        $this->validate();

        $department = new Department([
            'displayName' => $this->displayName,
            'manager' => $this->manager,
            'departmentNumber' => $this->departmentNumber,
            'departmentNumber2' => $this->departmentNumber2,
            'location_id' => $this->location_id,
            'status_id' => $this->status_id
        ]);

        $department->save();

        $this->reset();
    }
}
