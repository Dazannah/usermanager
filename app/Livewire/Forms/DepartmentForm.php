<?php

namespace App\Livewire\Forms;

use Exception;
use Livewire\Form;
use App\Models\Worker;
use App\Models\Department;
use App\Models\DepartmentManager;
use App\Models\Location;
use Illuminate\Validation\ValidationException;

class DepartmentForm extends Form {
    public Department|null $department;

    // livewire view properties
    public string|null $displayName;
    public string|null $department_manager_id = null;
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
        $this->department_manager_id = $this->department->department_manager_id;
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

        $this->validateWorker();
        $this->validateLocation();

        $this->department->displayName = $this->displayName;
        $this->department->department_manager_id = empty($this->department_manager_id) ? null : $this->department_manager_id;
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

        $this->validateWorker();
        $this->validateLocation();

        $department = new Department([
            'displayName' => $this->displayName,
            'department_manager_id' => empty($this->department_manager_id) ? null : $this->department_manager_id,
            'departmentNumber' => $this->departmentNumber,
            'departmentNumber2' => $this->departmentNumber2,
            'location_id' => $this->location_id,
            'status_id' => $this->status_id
        ]);

        $department->save();

        $this->reset();
    }

    public function validateWorker() {
        $error_message = null;

        $department_manager = DepartmentManager::where('id', '=', $this->department_manager_id)->first();
        $worker = Worker::where('id', '=', $department_manager?->worker_id)->first();

        if ($worker?->status->name == 'inactive')
            $error_message = 'Dolgozó inaktív.';

        if ($department_manager?->status->name == 'inactive')
            $error_message = 'Osztályvezető inaktív.';

        if (!is_null($error_message))
            throw ValidationException::withMessages([
                'form.department_manager_id' => [$error_message]
            ]);
    }

    public function validateLocation() {
        $location = Location::where('id', '=', $this->location_id)->first();
        if ($location->status->name == 'inactive')
            throw ValidationException::withMessages([
                'form.location_id' => ["Helyszín inaktív"]
            ]);
    }
}
