<?php

namespace App\Livewire\Admin;

use App\Models\Status;
use Livewire\Component;
use App\Models\Location;
use App\Models\Department;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Collection;

class Departments extends Component {
    use WithPagination;

    /** @var Collection<int,Status> $statuses*/
    public Collection $statuses;

    /** @var Collection<int,Location> $statuses*/
    public Collection $locations;

    //filter properties
    #[Url(as: 'displayName')]
    public string $search_department_displayName;
    #[Url(as: 'departmentNumber')]
    public string $search_department_departmentNumber;
    #[Url(as: 'departmentNumber2')]
    public string $search_department_departmentNumber2;
    #[Url(as: 'status_id')]
    public string $search_department_status_id;
    #[Url(as: 'location_id')]
    public string $search_department_location_id;

    public  $listeners = ['refresh_departments_mount', 'department_filter_reset'];

    public function __construct() {
        $this->filter_departments();
    }

    public function mount() {
        $this->statuses = Status::all();
        $this->locations = Location::all();
    }

    public function refresh_departments_mount() {
        $this->mount();
    }

    public function department_filter_reset() {
        $this->reset('search_department_displayName', 'search_department_departmentNumber', 'search_department_departmentNumber2', 'search_department_status_id', 'search_department_location_id');
        $this->resetPage();
        $this->dispatch('refresh_departments_mount');
    }

    //search
    public function filter_departments() {
        return Department::when(
            isset($this->search_department_displayName) && !empty($this->search_department_displayName),
            function ($query) {
                return $query->where('displayName', 'REGEXP', $this->search_department_displayName);
            }
        )->when(
            isset($this->search_department_departmentNumber) && !empty($this->search_department_departmentNumber),
            function ($query) {
                return $query->where('departmentNumber', 'REGEXP', $this->search_department_departmentNumber);
            }
        )->when(
            isset($this->search_department_departmentNumber2) && !empty($this->search_department_departmentNumber2),
            function ($query) {
                return $query->where('departmentNumber2', 'REGEXP', $this->search_department_departmentNumber2);
            }
        )->when(
            isset($this->search_department_status_id) && !empty($this->search_department_status_id),
            function ($query) {
                return $query->where('status_id', '=', $this->search_department_status_id);
            }
        )->when(
            isset($this->search_department_location_id) && !empty($this->search_department_location_id),
            function ($query) {
                return $query->where('location_id', '=', $this->search_department_location_id);
            }
        )->paginate(10);
    }



    public function render() {
        return view('livewire.admin.departments', [
            'departments' => $this->filter_departments()
        ])->layout('layouts.admin');
    }
}
