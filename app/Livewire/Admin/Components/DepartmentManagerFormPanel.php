<?php

namespace App\Livewire\Admin\Components;

use Exception;
use App\Models\Worker;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;
use App\Livewire\Forms\DepartmentManagerForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DepartmentManagerFormPanel extends Component {

    use WithPagination, WithoutUrlPagination;

    /** @var Collection<int,Status> $statuses */
    public Collection $statuses;

    public DepartmentManagerForm $form;

    public string|null $worker_name_search;
    public string|null $registration_number_search;

    public $listeners = ['worker_filter_reset', 'set_worker', 'update_department_manager_id', 'show_store_department_manager'];

    public function update_department_manager_id($department_manager_id) {
        $this->form->set_department_manager($department_manager_id);
    }

    public function worker_filter_reset() {
        $this->reset('worker_name_search', 'registration_number_search');
        $this->resetPage();
    }

    public function set_worker($id) {
        $worker = Worker::findOrFail($id);

        $this->form->worker_name = $worker->name;
        $this->form->registration_number = $worker->registration_number;
        $this->form->worker_id = $worker->id;
    }

    public function show_store_department_manager() {
        $this->form->reset();
    }

    public function delete_department_manager() {
        try {
            $this->form->delete();

            $this->dispatch('refresh_departments_mount');
            $this->dispatch('refresh_department_managers_mount');
            $this->dispatch('department_manager_delete_success');
        } catch (QueryException $err) {
            $err_message = $err->getMessage();

            if ($err->getCode() == 23000) {
                $this->addError('department_manager_delete_error', "Nem lehet törölni az osztálytvezető, mert valószínűleg kapcsolódik más adatokhoz (pl. osztályhoz van rendelve ).");

                return;
            }

            $this->addError('department_manager_delete_error', "Ismeretlen hiba történt: $err_message");
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('department_manager_delete_error', $err->getMessage());
        }
    }

    public function update_department_manager() {
        try {
            $this->form->update();

            $this->dispatch('refresh_departments_mount');
            $this->dispatch('refresh_department_managers_mount');
            $this->dispatch('department_manager_save_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('department_manager_delete_error', $err->getMessage());
        }
    }

    public function create_department_manager() {
        try {
            $this->form->create();

            $this->dispatch('refresh_departments_mount');
            $this->dispatch('refresh_department_managers_mount');
            $this->dispatch('department_manager_save_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('department_manager_delete_error', $err->getMessage());
        }
    }

    public function filter_workers() {
        return Worker::where('status_id', '=', '1')->where('is_technical', '=', '0')->doesntHave('department_manager')->when(
            isset($this->worker_name_search) && !empty($this->worker_name_search),
            function ($query) {
                return $query->where('name', 'LIKE', "%$this->worker_name_search%");
            }
        )->when(
            isset($this->registration_number_search) && !empty($this->registration_number_search),
            function ($query) {
                return $query->where('registration_number', 'LIKE', "%$this->registration_number_search%");
            }
        )->paginate(8);
    }

    public function render() {
        return view('livewire.admin.components.department-manager-form-panel', [
            'workers' => $this->filter_workers()
        ]);
    }
}
