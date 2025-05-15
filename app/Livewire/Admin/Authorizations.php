<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\On;

class Authorizations extends Component {
    public $show_add_column_field, $show_add_authorization_field, $show_add_sub_authorization_field;

    public function mount() {
        $this->show_add_column_field = false;
        $this->show_add_authorization_field = false;
        $this->show_add_sub_authorization_field = false;
    }

    public function toggle_add_column_field() {
        $this->show_add_column_field = !$this->show_add_column_field;
    }

    public function save_column() {
    }

    public function save_authorization() {
    }

    public function save_sub_authorization() {
    }

    public function render() {
        return view('livewire.admin.authorizations')->layout('layouts.admin');
    }
}
