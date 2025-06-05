<?php

namespace App\Livewire\Setup;

use Livewire\Component;

class AuthLevels extends Component {
    public function render() {
        return view('livewire.setup.auth-levels')->layout('layouts.admin');
    }
}
