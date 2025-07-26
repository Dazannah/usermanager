<?php

namespace App\Livewire\User;

use App\Models\Column;
use Livewire\Component;
use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;

class CreateNewWorkerRequest extends Component {

    /** @var Collection<int,Department> */
    public Collection $departments;
    /** @var Collection<int,Column> */
    public Collection $columns;

    public function mount() {
        $this->departments = Department::all();
        $this->columns = Column::all();
    }

    public function render() {
        return view('livewire.user.create-new-worker-request');
    }
}
