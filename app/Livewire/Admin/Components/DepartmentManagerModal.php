<?php

namespace App\Livewire\Admin\Components;

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class DepartmentManagerModal extends Component {

    public function filter_department_managers() {
        return [];
    }

    public function render() {
        return view('livewire.admin.components.department-manager-modal', [
            'department_managers' => $this->filter_department_managers()
        ]);
    }
}
