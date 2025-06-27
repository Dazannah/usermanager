<?php

namespace App\Livewire\Admin;

use App\Models\Column;
use Livewire\Component;
use App\Models\Department;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\WorkerRequest;
use App\Models\WorkerRequestStatus;
use App\Models\WorkerRequestProcess;
use Illuminate\Database\Eloquent\Collection;

class Requests extends Component {
    use WithPagination;

    /** @var Collection<int,WorkerRequestStatus> */
    public Collection $statuses;

    /** @var Collection<int,WorkerRequestProcess> */
    public Collection $process;

    /** @var Collection<int,Department> */
    public Collection $departments;

    /** @var Collection<int,Department> */
    public Collection $columns;

    //filter properties
    #[Url]
    public string|null $name;
    #[Url]
    public bool|null $is_technical;
    #[Url]
    public int|null $department_id;
    #[Url(as: 'process_id')]
    public int|null $worker_request_process_id;
    #[Url(as: 'status_id')]
    public int|null $worker_request_status_id;
    #[Url(as: 'requester')]
    public string|null $requester;

    public $listeners = ['refresh_requests_mount', 'requests_filter_reset'];

    public function refresh_requests_mount() {
        $this->mount();
    }
    public function mount() {
        $this->statuses = WorkerRequestStatus::all();
        $this->process = WorkerRequestProcess::all();
        $this->departments = Department::all();
        $this->columns = Column::all_sorted_auth_items_by_position();
    }

    public function requests_filter_reset() {
        $this->reset('name', 'is_technical', 'department_id', 'worker_request_process_id', 'worker_request_status_id', 'requester');
        $this->resetPage();
        $this->dispatch('refresh_requests_mount');
    }

    //search
    public function filter_requests() {
        return WorkerRequest::when(
            isset($this->name) && !empty($this->name),
            function ($query) {
                return $query->where('name', 'REGEXP', $this->name);
            }
        )->when(
            isset($this->is_technical) && $this->is_technical,
            function ($query) {
                return $query->where('is_technical', '=', 1);
            }
        )->when(
            isset($this->department_id) && !empty($this->department_id),
            function ($query) {
                return $query->whereHas('departments', function ($q) {
                    $q->where('departments.id', '=', $this->department_id);
                });
            }
        )->when(
            isset($this->worker_request_process_id) && !empty($this->worker_request_process_id),
            function ($query) {
                return $query->whereHas('process', function ($q) {
                    $q->where('id', '=', $this->worker_request_process_id);
                });
            }
        )->when(
            isset($this->worker_request_status_id) && !empty($this->worker_request_status_id),
            function ($query) {
                return $query->whereHas('status', function ($q) {
                    $q->where('id', '=', $this->worker_request_status_id);
                });
            }
        )->when(
            isset($this->requester) && !empty($this->requester),
            function ($query) {
                return $query->whereHas('requester', function ($q) {
                    $q->where('username', 'REGEXP', $this->requester);
                });
            }
        )->paginate(15);
    }

    public function render() {
        return view('livewire.admin.requests', [
            'requests' => $this->filter_requests()
        ])->layout('layouts.admin');
    }
}
