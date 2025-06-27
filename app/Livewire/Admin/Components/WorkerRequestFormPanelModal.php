<?php

namespace App\Livewire\Admin\Components;

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class WorkerRequestFormPanelModal extends Component {
    /** @var Collection<int,Department> */
    public Collection $departments;

    /** @var Collection<int,Department> */
    public Collection $columns;

    public function render() {
        return view('livewire.admin.components.worker-request-form-panel-modal');
    }
}
