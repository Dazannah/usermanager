<?php

namespace App\Livewire\Admin\Components;

use Exception;
use Livewire\Component;
use App\Models\Department;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class EditDepartment extends Component {
    /** @var Collection<int,Status> $statuses */
    public Collection $statuses;

    /** @var Collection<int,Location> $locations */
    public Collection $locations;

    public Department $edit_department;

    // livewire view properties
    public string $edit_department_displayName;
    public string|null $edit_department_departmentNumber;
    public string|null $edit_department_departmentNumber2;
    public int $edit_department_status_id;
    public int $edit_department_location_id;

    protected $listeners = ['edit_department_id'];

    public function edit_department_id($edit_department_id) {
        $this->edit_department = Department::where('id', $edit_department_id)->first();

        $this->edit_department_displayName = $this->edit_department->displayName;
        $this->edit_department_departmentNumber = $this->edit_department->departmentNumber;
        $this->edit_department_departmentNumber2 = $this->edit_department->departmentNumber2;
        $this->edit_department_status_id = $this->edit_department->status_id;
        $this->edit_department_location_id = $this->edit_department->location_id;
    }

    public function save_edit_department() {
        try {
            $rules = [
                'edit_department_displayName' => 'required',
                'edit_department_status_id' => 'required|exists:App\Models\Status,id',
                'edit_department_location_id' => 'required|exists:App\Models\Location,id'
            ];

            $messages = [
                'edit_department_displayName.required' => 'Elnevezés megadása kötelező',
                'edit_department_status_id.required' => 'Státusz kiválasztása kötelező',
                'edit_department_status_id.exists' => 'Kiválasztott státusz nem létezik.',
                'edit_department_location_id.required' => 'Helyszín kiválasztása kötelező',
                'edit_department_location_id.exists' => 'Kiválasztott helyszín nem létezik.',
            ];

            $this->validate($rules, $messages);

            $this->edit_department->displayName = $this->edit_department_displayName;
            $this->edit_department->departmentNumber = $this->edit_department_departmentNumber;
            $this->edit_department->departmentNumber2 = $this->edit_department_departmentNumber2;
            $this->edit_department->status_id = $this->edit_department_status_id;
            $this->edit_department->location_id = $this->edit_department_location_id;

            $this->edit_department->save();

            $this->dispatch('refresh_departments_mount');
            $this->dispatch('save_edit_department_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('save_edit_department_error', $err->getMessage());
        }
    }

    public function delete_edit_department() {
        try {
            $delete_result = $this->edit_department->delete();

            if (!isset($delete_result))
                throw new Exception('Törölni kívánt osztály nem található.');

            $this->dispatch('edit_department_delete_success');
        } catch (QueryException $err) {
            $err_message = $err->getMessage();

            if ($err->getCode() == 23000) {
                $this->addError('save_edit_department_error', "Nem lehet törölni ezt az osztályt, mert valószínűleg kapcsolódik más adatokhoz (pl. felhasználóhoz van rendelve ).");

                return;
            }

            $this->addError('save_edit_department_error', "Ismeretlen hiba történt: $err_message");
        } catch (Exception $err) {
            $this->addError('save_edit_department_error', $err->getMessage());
        } finally {
            $this->dispatch('refresh_departments_mount');
        }
    }

    public function render() {
        return view('livewire.admin.components.edit-department');
    }
}
