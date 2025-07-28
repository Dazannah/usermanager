<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;

class DepartmentManagerForm extends Form {
    public int|null $worker_id;
    public int|null $status_id = 1;
    public string|null $note;

    public string|null $worker_name;
    public string|null $registration_number;
}
