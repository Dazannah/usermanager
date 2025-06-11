<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\RequestProcess;
use Livewire\Attributes\Validate;

class UserRequestForm extends Form {
    public string|null $name;
    public RequestProcess|null $process;
    public bool|null $is_technical;
    public string|null $registration_number;
    public int|null $repartment_id;
    public array $depatments = [];
    public string|null $department_leader;
    public string $post;
    public array $authorizations = [];
    public array $sub_authorizations = [];
}
