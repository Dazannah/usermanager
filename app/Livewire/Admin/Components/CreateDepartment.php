<?php

namespace App\Livewire\Admin\Components;

use App\Models\Department;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CreateDepartment extends Component {
    /** @var Collection<int,Status> $statuses */
    public Collection $statuses;

    /** @var Collection<int,Location> $locations */
    public Collection $locations;

    // livewire view properties
    public string $create_department_displayName;
    public string|null $create_department_departmentNumber;
    public string|null $create_department_departmentNumber2;
    public int $create_department_location_id;
    public int $create_department_status_id = 1;

    public $rules = [
        'create_department_displayName' => 'required',
        'create_department_status_id' => 'required|exists:App\Models\Status,id',
        'create_department_location_id' => 'required|exists:App\Models\Location,id'
    ];

    public $messages = [
        'create_department_displayName.required' => 'Elnevezés megadása kötelező',
        'create_department_status_id.required' => 'Státusz kiválasztása kötelező',
        'create_department_status_id.exists' => 'Kiválasztott státusz nem létezik.',
        'create_department_location_id.required' => 'Helyszín kiválasztása kötelező',
        'create_department_location_id.exists' => 'Kiválasztott helyszín nem létezik.',
    ];

    public function save_new_department() {
        try {
            $this->validate($this->rules, $this->messages);

            $department = new Department([
                'displayName' => $this->create_department_displayName,
                'departmentNumber' => $this->create_department_departmentNumber ?? null,
                'departmentNumber2' => $this->create_department_departmentNumber2 ?? null,
                'location_id' => $this->create_department_location_id,
                'status_id' => $this->create_department_status_id
            ]);

            $department->save();

            $this->reset('create_department_displayName', 'create_department_departmentNumber', 'create_department_departmentNumber2', 'create_department_status_id', 'create_department_location_id');
            $this->dispatch('refresh_departments_mount');
            $this->dispatch('save_new_department_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('save_new_department_error', $err->getMessage());
        }
    }

    public function render() {
        return view('livewire.admin.components.create-department');
    }
}
