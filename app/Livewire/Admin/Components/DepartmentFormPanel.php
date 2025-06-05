<?php

namespace App\Livewire\Admin\Components;

use Exception;
use Livewire\Component;
use App\Models\Department;
use App\Livewire\Forms\DepartmentForm;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class DepartmentFormPanel extends Component {
    /** @var Collection<int,Status> $statuses */
    public Collection $statuses;

    /** @var Collection<int,Location> $locations */
    public Collection $locations;

    public DepartmentForm $form;

    protected $listeners = ['update_department_id', 'show_store_department'];

    public function update_department_id($department_id) {
        $this->form->set_department($department_id);
    }

    public function show_store_department() {
        $this->form->delete_current_data();
    }

    public function update_department() {
        try {

            $this->form->update();

            $this->dispatch('refresh_departments_mount');
            $this->dispatch('update_department_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('save_edit_department_error', $err->getMessage());
        }
    }

    public function delete_department() {
        try {
            $this->form->delete();

            $this->dispatch('department_delete_success');
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

    public function store_department() {
        try {
            $this->form->store();

            $this->dispatch('refresh_departments_mount');
            $this->dispatch('update_department_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('save_new_department_error', $err->getMessage());
        }
    }

    public function render() {
        return view('livewire.admin.components.department-form-panel');
    }
}
