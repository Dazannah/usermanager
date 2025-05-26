<?php

namespace App\Livewire\Admin;

use App\Models\Department;
use App\Models\Location;
use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Departments extends Component {
    /** @var Collection<int,Status> $statuses*/
    public Collection $statuses;

    /** @var Collection<int,Location> $statuses*/
    public Collection $locations;

    /** @var Collection<int,Department> $statuses*/
    public Collection $departments;

    public  $listeners = ['refresh_departments_mount'];

    public function mount() {
        $this->statuses = Status::all();
        $this->locations = Location::all();
        $this->departments = Department::all();
    }

    public function refresh_departments_mount() {
        $this->mount();
    }

    public function render() {
        return view('livewire.admin.departments')->layout('layouts.admin');
    }
}
