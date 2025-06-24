<?php

namespace App\Livewire\User\Components;

use Livewire\Component;
use App\Livewire\Forms\WorkerRequestForm;
use Illuminate\Database\Eloquent\Collection;

class WorkerRequestFormPanel extends Component {

    /** @var Collection<int,Department> */
    public Collection $departments;
    /** @var Collection<int,Column> */
    public Collection $columns;

    public WorkerRequestForm $form;

    public function render() {
        return view('livewire.user.components.worker-request-form-panel');
    }
}
