<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Livewire\Actions\Logout;

class AdminNavigation extends Component {
    public function render() {
        return view('livewire.layout.admin-navigation');
    }

    public function logout(Logout $logout): void {
        $logout();

        $this->redirect('/login', navigate: true);
    }
}
