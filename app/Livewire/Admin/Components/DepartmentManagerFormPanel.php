<?php

namespace App\Livewire\Admin\Components;

use App\Models\Worker;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Database\Eloquent\Collection;
use App\Livewire\Forms\DepartmentManagerForm;

class DepartmentManagerFormPanel extends Component {

    use WithPagination, WithoutUrlPagination;

    /** @var Collection<int,Status> $statuses */
    public Collection $statuses;

    public DepartmentManagerForm $form;

    public string|null $worker_name_search;
    public string|null $registration_number_search;

    public $listeners = ['worker_filter_reset', 'set_worker'];

    public function set_worker($id) {
        $worker = Worker::findOrFail($id);

        $this->form->worker_name = $worker->name;
        $this->form->registration_number = $worker->registration_number;
        $this->form->worker_id = $worker->id;
    }

    public function worker_filter_reset() {
        $this->reset('worker_name_search', 'registration_number_search');
        $this->resetPage();
    }

    public function filter_workers() {
        return Worker::where('status_id', '=', '1')->where('is_technical', '=', '0')->when(
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
