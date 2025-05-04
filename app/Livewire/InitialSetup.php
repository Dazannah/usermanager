<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class InitialSetup extends Component {
    public $app_name = 'Felhasználó kezelő';

    public $db_host = 'asd';
    public $db_port = 3306;
    public $db_databasename = 'asd';
    public $db_username = 'asd';
    public $db_password = 'asd';

    protected $rules = [
        'app_name' => 'required',
        'db_host' => 'required',
        'db_port' => 'required|integer|min:1|max:65535',
        'db_databasename' => 'required',
        'db_username' => 'required',
        'db_password' => 'required'
    ];

    protected $messages = [
        'app_name.required' => 'Alkalmazás név megadása körtelező.',
        'db_host.required' => 'Adatbázis szerver cím megadása kötelező.',
        'db_port.required' => 'Adatbázis szerver port megadása kötelező.',
        'db_databasename.required' => 'Adatbázis név megadása kötelező.',
        'db_username.required' => 'Adatbázis felhasználónév megadása kötelező.',
        'db_password.required' => 'Adatbázis felhasználó jelszó cím megadása kötelező.'
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function save() {
        $this->validate();

        file_put_contents(
            base_path('.env'),
            preg_replace('/\nAPP_NAME=.*/', "\nAPP_NAME=" . "'$this->app_name'", file_get_contents(base_path('.env')))
        );

        Artisan::call('config:cache');

        redirect('/');
    }

    public function render() {
        return view('livewire.initial-setup')->layout('layouts.guest');
    }
}
