<?php

namespace App\Livewire\User;

use App\Models\Column;
use Livewire\Component;
use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;

class CreateNewUserRequest extends Component {

    /** @var Collection<int,Department> */
    public Collection $departments;
    /** @var Collection<int,Column> */
    public Collection $columns;

    public function mount() {
        $this->departments = Department::all();
        $this->columns = Column::all_sorted_auth_items_by_position();
    }

    public function render() {
        return view('livewire.user.create-new-user-request');
    }
}
