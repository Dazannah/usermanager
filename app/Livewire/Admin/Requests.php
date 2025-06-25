<?php

namespace App\Livewire\Admin;

use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\WorkerRequest;
use App\Models\WorkerRequestProcess;
use App\Models\WorkerRequestStatus;
use Illuminate\Database\Eloquent\Collection;

class Requests extends Component {
    use WithPagination;

    /** @var Collection<int,WorkerRequestStatus> */
    public Collection $statuses;

    /** @var Collection<int,WorkerRequestProcess> */
    public Collection $process;

    /** @var Collection<int,Department> */
    public Collection $departments;

    public function mount() {
        $this->statuses = WorkerRequestStatus::all();
        $this->process = WorkerRequestProcess::all();
        $this->departments = Department::all();
    }

    //search
    public function filter_requests() {
        return WorkerRequest::when(
            isset($this->search_location_displayName) && !empty($this->search_location_displayName),
            function ($query) {
                return $query->where('displayName', 'REGEXP', $this->search_location_displayName);
            }
        )->when(
            isset($this->search_location_status_id),
            function ($query) {
                return $query->where('status_id', '=', $this->search_location_status_id);
            }
        )->when(
            isset($this->search_location_note) && !empty($this->search_location_note),
            function ($query) {
                return $query->where('note', 'REGEXP', $this->search_location_note);
            }
        )->paginate(15);
    }

    public function render() {
        return view('livewire.admin.requests', [
            'requests' => $this->filter_requests()
        ])->layout('layouts.admin');
    }
}
