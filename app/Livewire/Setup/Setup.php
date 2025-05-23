<?php

namespace App\Livewire\Setup;

use Livewire\Component;

class Setup extends Component {
    public function render() {
        return view('livewire.setup.setup')->layout('layouts.admin');
    }
}
