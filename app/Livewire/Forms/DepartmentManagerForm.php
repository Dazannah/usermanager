<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Worker;
use App\Models\Department;
use Illuminate\Validation\Rule;
use App\Models\DepartmentManager;
use Livewire\Attributes\Validate;
use App\Livewire\Admin\Departments;
use Illuminate\Validation\ValidationException;

class DepartmentManagerForm extends Form {
    public int|null $worker_id;
    public int|null $status_id = 1;

    public string|null $worker_name;
    public string|null $registration_number;

    public $update_rules = [
        'worker_id' => 'required',
        'status_id' => 'required'
    ];

    public function rules() {
        return [
            'worker_id' => [
                'required',
                Rule::unique('department_managers', 'worker_id')
            ],
            'status_id' => 'required',
        ];
    }

    public function messages() {
        return [
            'worker_id.required' => 'Dolgozó megadása kötelező',
            'worker_id.unique' => 'Dolgozó már regisztrálva van osztályvezetőnek.',
            'status_id.required' => 'Státusz megadása kötelező.',
        ];
    }

    public function set_department_manager($department_manager_id) {
        $department_manager = DepartmentManager::where('id', '=', $department_manager_id)->first();

        $this->worker_id = $department_manager->worker_id;
        $this->status_id = $department_manager->status_id;

        $worker = Worker::where('id', '=', $this->worker_id)->first();

        $this->worker_name = $worker->name;
        $this->registration_number = $worker->registration_number;
    }

    public function create() {
        $this->validate($this->rules(), $this->messages());

        $department_manager = DepartmentManager::create([
            'worker_id' => $this->worker_id,
            'status_id' => $this->status_id
        ]);

        $department_manager->save();

        $this->reset();
    }

    public function delete() {
        $department_manager = DepartmentManager::where("worker_id", "=", $this->worker_id)->first();

        $department_manager->delete();

        $this->reset();
    }

    public function update() {
        $this->validate($this->update_rules, $this->messages());

        $department_manager = DepartmentManager::where("worker_id", "=", $this->worker_id)->first();

        $departments_with_this_manager = Department::where("department_manager_id", "=", $department_manager->id)->where('status_id', '=', 1)->get();

        if ($this->status_id == 2 && count($departments_with_this_manager) > 0)
            throw ValidationException::withMessages([
                'form.status_id' => ["Az osztályvezető 1 vagy több aktív osztályhoz van rendelve."]
            ]);

        $department_manager->status_id = $this->status_id;

        $department_manager->save();
    }
}
