<?php

namespace App\Livewire;

use App\Models\User;
use Exception;
use Livewire\Component;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class InitialSetup extends Component {
    public $app_name = 'Felhasználó kezelő';

    public $db_host = '';
    public $db_port = 3306;
    public $db_databasename = '';
    public $db_username = '';
    public $db_password = '';

    public $admin_username = '';
    public $admin_email = '';
    public $password = '';
    public $password_confirmation = '';

    protected $rules = [
        'app_name' => 'required',
        'db_host' => 'required',
        'db_port' => 'required|integer|min:1|max:65535',
        'db_databasename' => 'required',
        'db_username' => 'required',
        'db_password' => 'required',
        'admin_username' => 'required|max:255',
        'admin_email' => 'required|email|max:255',
        'password' => "required|confirmed"
    ];

    protected $messages = [
        'app_name.required' => 'Alkalmazás név megadása körtelező.',
        'db_host.required' => 'Adatbázis szerver cím megadása kötelező.',
        'db_port.required' => 'Adatbázis szerver port megadása kötelező.',
        'db_databasename.required' => 'Adatbázis név megadása kötelező.',
        'db_username.required' => 'Adatbázis felhasználónév megadása kötelező.',
        'db_password.required' => 'Adatbázis felhasználó jelszó cím megadása kötelező.',
        'admin_username.required' => 'Admin felhasználónév megadása kötelező.',
        'admin_username.max' => 'Admin felhasználónév túl hosszú.',
        'admin_email.required' => 'Admin email cím megadása kötelező.',
        'admin_email.email' => 'Email cím megadása kötelező.',
        'password.required' => 'Admin jelszó megadása kötelező.',
        'password.confirmed' => 'Megadott jelszavak nem egyeznek.',
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function save() {

        $this->validate();
        $this->validate(['password' => [Rules\Password::defaults()]]);

        //sikeres validáció után .env módosítása és mentése
        $env_content = $original_env_content = file_get_contents(base_path('.env'));

        try {
            $env_content = preg_replace('/\nAPP_NAME=.*/', "\nAPP_NAME=" . "'$this->app_name'", $env_content);

            $env_content = preg_replace('/\nDB_HOST=.*/', "\nDB_HOST=" . "'$this->db_host'", $env_content);
            $env_content = preg_replace('/\nDB_PORT=.*/', "\nDB_PORT=" . "'$this->db_port'", $env_content);
            $env_content = preg_replace('/\nDB_DATABASE=.*/', "\nDB_DATABASE=" . "'$this->db_databasename'", $env_content);
            $env_content = preg_replace('/\nDB_USERNAME=.*/', "\nDB_USERNAME=" . "'$this->db_username'", $env_content);
            $env_content = preg_replace('/\nDB_PASSWORD=.*/', "\nDB_PASSWORD=" . "'$this->db_password'", $env_content);

            $env_content = preg_replace('/APP_INSTALLED=.*/', "APP_INSTALLED=true", $env_content);
            $env_content = preg_replace('/SESSION_DRIVER=.*/', "SESSION_DRIVER=database", $env_content);

            file_put_contents(
                base_path('.env'),
                $env_content
            );

            //módosított .env betöltése memóriába
            Artisan::call('config:clear');
            Artisan::call('config:cache');

            //adatbázis migráció
            Artisan::call('migrate', array(
                '--path' => 'database/migrations',
                '--database' => 'mysql',
                '--force' => true
            ));

            //alapértelmezett rendszergazda fiók létrehozása
            $user_data['name'] = $this->admin_username;
            $user_data['email'] = $this->admin_email;
            $user_data['password'] = Hash::make($this->password);

            User::create($user_data);

            return redirect()->to('/');
        } catch (Exception $err) {
            session()->flash('message', $err->getMessage());

            //hiba esetén a változatlan .env vissza töltése
            file_put_contents(
                base_path('.env'),
                $original_env_content
            );

            Artisan::call('config:clear');
        }
    }

    public function render() {
        return view('livewire.initial-setup', [
            'errors' => session()->get('errors') ?: new \Illuminate\Support\ViewErrorBag()
        ])->layout('layouts.guest');
    }
}
