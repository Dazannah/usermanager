<?php

namespace App\Livewire;

use Exception;
use App\Models\User;
use Livewire\Component;
use LdapRecord\Container;
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

    public $ldap_active = false;
    public $ldap_host = '';
    public $ldap_port = 389;
    public $ldap_username = '';
    public $ldap_password = '';
    public $ldap_base_dn = 'dc=local,dc=com';

    protected $rules = [
        'app_name' => 'required',
        'db_host' => 'required',
        'db_port' => 'required|integer|min:1|max:65535',
        'db_databasename' => 'required',
        'db_username' => 'required',
        'db_password' => 'required',
        'admin_username' => 'required|max:255',
        'admin_email' => 'required|email|max:255',
        'password' => 'required|confirmed',
        'ldap_host' => 'required',
        'ldap_port' => 'required',
        'ldap_username' => 'required',
        'ldap_password' => 'required',
        'ldap_base_dn' => 'required'
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
        'ldap_host.required' => 'LDAP szerver cím megadása kötelező.',
        'ldap_port.required' => 'LDAP szerver port megadása kötelező.',
        'ldap_username.required' => 'LDAP felhasználónév megadása kötelező.',
        'ldap_password.required' => 'LDAP felhasználó jelszó megadása kötelező.',
        'ldap_base_dn.required' => 'LDAP DN megadása kötelező.'
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function toggle_ldap_active() {
        $this->ldap_active = !$this->ldap_active;
    }

    public function test_ldap_connection() {
        $this->validate();

        try {
            config([
                'ldap.connections.default.host' => $this->ldap_host,
                'ldap.connections.default.port' => $this->ldap_port,
                'ldap.connections.default.username' => $this->ldap_username,
                'ldap.connections.default.password' => $this->ldap_password,
                'ldap.connections.default.base_dn' => $this->ldap_base_dn,
            ]);

            $connection = Container::getConnection('default');

            $connection->connect();
            $connection->auth()->attempt();

            return true;
        } catch (Exception $err) {
            return $err->getMessage();
        }
    }

    public function test_ldap_connection_standalone() {
        $result = $this->test_ldap_connection();

        if ($result === true) {
            session()->flash('ldap_test_result', "Sikeres kapcsolat kiépítés.");

            return;
        } else {
            $this->addError('ldap_test_result_error', $result);

            return;
        }
    }

    public function test_database_connection() {
        $this->validate();

        try {
            config([
                'database.connections.mysql.host' => $this->db_host,
                'database.connections.mysql.port' => $this->db_port,
                'database.connections.mysql.database' => null,
                'database.connections.mysql.username' => $this->db_username,
                'database.connections.mysql.password' => $this->db_password
            ]);

            DB::connection()->getPDO();

            return true;
        } catch (Exception $err) {
            return $err->getMessage();
        }
    }

    public function test_database_connection_standalone() {
        $result = $this->test_database_connection();

        if ($result === true) {
            session()->flash('db_test_result', "Sikeres kapcsolat kiépítés.");

            return;
        } else {
            $this->addError('db_test_result_error', $result);

            return;
        }
    }

    public function save() {
        $this->validate();
        $this->validate(['password' => [Rules\Password::defaults()]]);

        //database 
        $db_test_result = $this->test_database_connection();

        if ($db_test_result !== true) {
            $this->addError('db_test_result_error', $db_test_result);

            return;
        }

        if ($this->ldap_active === true) {
            $ldap_test_result = $this->test_ldap_connection();

            if ($ldap_test_result !== true) {
                $this->addError('ldap_test_result_error', $ldap_test_result);

                return;
            }
        }

        //sikeres validáció után .env módosítása és mentése
        $env_content = $original_env_content = file_get_contents(base_path('.env'));
        $original_database_connctions = config('database.connctions');

        try {
            $env_content = preg_replace('/\nAPP_NAME=.*/', "\nAPP_NAME=" . "'$this->app_name'", $env_content);

            $env_content = preg_replace('/\nDB_HOST=.*/', "\nDB_HOST=" . "'$this->db_host'", $env_content);
            $env_content = preg_replace('/\nDB_PORT=.*/', "\nDB_PORT=" . "'$this->db_port'", $env_content);
            $env_content = preg_replace('/\nDB_DATABASE=.*/', "\nDB_DATABASE=" . "'$this->db_databasename'", $env_content);
            $env_content = preg_replace('/\nDB_USERNAME=.*/', "\nDB_USERNAME=" . "'$this->db_username'", $env_content);
            $env_content = preg_replace('/\nDB_PASSWORD=.*/', "\nDB_PASSWORD=" . "'$this->db_password'", $env_content);

            $env_content = preg_replace('/APP_INSTALLED=.*/', "APP_INSTALLED=true", $env_content);
            $env_content = preg_replace('/SESSION_DRIVER=.*/', "SESSION_DRIVER=database", $env_content);

            config([
                'app.name' => $this->app_name,
                'app.installed' => true,
                'session.driver' => 'database',
                'database.connections.mysql.host' => $this->db_host,
                'database.connections.mysql.port' => $this->db_port,
                'database.connections.mysql.database' => $this->db_databasename,
                'database.connections.mysql.username' => $this->db_username,
                'database.connections.mysql.password' => $this->db_password
            ]);

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

            file_put_contents(
                base_path('.env'),
                $env_content
            );

            return redirect()->to('/');
        } catch (Exception $err) {
            session()->flash('message', $err->getMessage());

            //hiba esetén a változatlan .env vissza töltése
            file_put_contents(
                base_path('.env'),
                $original_env_content
            );

            //function elején kimentett konf vissza töltése
            config([
                'session.driver' => 'file',
                'app.installed' => false,
                'database.connections' => $original_database_connctions
            ]);
        }
    }

    public function render() {
        return view('livewire.initial-setup')->layout('layouts.guest');
    }
}
