<?php

namespace App\Livewire\User\Components;

use Livewire\Component;
use App\Livewire\Forms\UserRequestForm;
use Illuminate\Database\Eloquent\Collection;

class UserRequestFormPanel extends Component {

    /** @var Collection<int,Department> */
    public Collection $departments;
    /** @var Collection<int,Column> */
    public Collection $columns;

    public UserRequestForm $form;

    public function render() {
        return view('livewire.user.components.user-request-form-panel');
    }
}
