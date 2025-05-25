<?php

namespace App\Livewire\Setup\Components;

use Livewire\Component;

class IspoconfigSoapSettingsComponent extends Component {
    public bool $active;
    public string|null $uri;
    public string|null $location;
    public string|null $username;
    public string|null $password;

    public function render() {
        return view('livewire.setup.components.ispoconfig-soap-settings-component');
    }
}
