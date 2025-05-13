<?php

namespace App\Livewire;

use Livewire\Component;

class Authorizations extends Component {
    public function render() {
        return view('livewire.admin.authorizations')->layout('layouts.admin');
    }
}
