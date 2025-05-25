<?php

namespace App\Livewire\Setup;

use Exception;
use SoapClient;
use App\Models\User;
use App\Mail\MailTest;
use App\Models\Status;
use Livewire\Component;
use LdapRecord\Connection;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;

class InitialSetup extends Component {
    //todo feltördelni, külön külön menthetővé tenni, nehezen kiegészíthető

    public $db_host;
    public $db_port;
    public $db_databasename;
    public $db_username;
    public $db_password;

    public $admin_name;
    public $admin_username;
    public $admin_email;
    public $password;
    public $password_confirmation;

    public $ispfonfig_active;
    public $ispconfig_soap_uri;
    public $ispconfig_soap_location;
    public $ispconfig_soap_remote_username;
    public $ispconfig_soap_remote_user_password;

    private $user_principal_name;

    protected $rules = [
        'db_host' => 'required',
        'db_port' => 'required|integer|min:1|max:65535',
        'db_databasename' => 'required',
        'db_username' => 'required',
        'db_password' => 'required',
        'admin_name' => 'max:255',
        'admin_username' => 'required|max:255',
        'admin_email' => 'required|email|max:255',
        'password' => 'required|confirmed',
    ];

    protected $messages = [
        'db_host.required' => 'Adatbázis szerver cím megadása kötelező.',
        'db_port.required' => 'Adatbázis szerver port megadása kötelező.',
        'db_port.integer' => 'Az adatbázis portnak egész számnak kell lennie.',
        'db_port.min' => 'Az adatbázis port minimum 1 lehet.',
        'db_port.max' => 'Az adatbázis port maximum 65535 lehet.',
        'db_databasename.required' => 'Adatbázis név megadása kötelező.',
        'db_username.required' => 'Adatbázis felhasználó név megadása kötelező.',
        'db_password.required' => 'Adatbázis felhasználó jelszó cím megadása kötelező.',
        'admin_username.required' => 'Admin felhasználónév megadása kötelező.',
        'admin_username.max' => 'Admin felhasználónév túl hosszú.',
        'admin_email.required' => 'Admin email cím megadása kötelező.',
        'admin_email.email' => 'Email cím megadása kötelező.',
        'password.required' => 'Admin jelszó megadása kötelező.',
        'password.confirmed' => 'Megadott jelszavak nem egyeznek.',
    ];

    public function mount() {
        $this->db_host = config('database.connections.mysql.host');
        $this->db_port = config('database.connections.mysql.port');
        $this->db_databasename = config('database.connections.mysql.database');
        $this->db_username = config('database.connections.mysql.username');
        $this->db_password = config('database.connections.mysql.password');

        if (!config('app.installed')) {
            $this->admin_name = '';
            $this->admin_username = 'usermanager_admin';
            $this->admin_email = '';
            $this->password = '';
            $this->password_confirmation = '';
        }

        $this->ispfonfig_active = config('ispconfig.soap.active');
        $this->ispconfig_soap_uri = config('ispconfig.soap.connection.uri');
        $this->ispconfig_soap_location = config('ispconfig.soap.connection.location');
        $this->ispconfig_soap_remote_username = config('ispconfig.soap.connection.username');
        $this->ispconfig_soap_remote_user_password = config('ispconfig.soap.connection.password');
    }

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function validate_only_array($field_names) {
        foreach ($field_names as $field_name) {
            $this->validate($field_name);
        }
    }

    public function test_database_connection() {
        try {
            config([
                'database.connections.mysql.host' => $this->db_host,
                'database.connections.mysql.port' => $this->db_port,
                'database.connections.mysql.database' => $this->db_databasename,
                'database.connections.mysql.username' => $this->db_username,
                'database.connections.mysql.password' => $this->db_password
            ]);

            DB::connection()->getPDO();
            DB::disconnect();

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


        //mail setup test before save
        $mail_test_result = $this->test_mail_connection();

        if ($mail_test_result !== true) {
            $this->addError('mail_test_result_error', $mail_test_result);

            return;
        }

        //database setup test before save
        $db_test_result = $this->test_database_connection();

        if ($db_test_result !== true) {
            $this->addError('db_test_result_error', $db_test_result);

            return;
        }

        //sikeres validáció után .env módosítása és mentése
        $env_content = $original_env_content = file_get_contents(base_path('.env'));
        $original_database_connctions = config('database.connctions');

        try {
            //general configs
            $env_content = preg_replace('/APP_NAME=.*/', "APP_NAME='$this->app_name'", $env_content);
            $env_content = preg_replace('/SESSION_DRIVER=.*/', "SESSION_DRIVER=database", $env_content);

            config([
                'app.name' => $this->app_name,
                'session.driver' => 'database',
            ]);

            //database configs
            $env_content = preg_replace('/DB_HOST=.*/', "DB_HOST='$this->db_host'", $env_content);
            $env_content = preg_replace('/DB_PORT=.*/', "DB_PORT='$this->db_port'", $env_content);
            $env_content = preg_replace('/DB_DATABASE=.*/', "DB_DATABASE='$this->db_databasename'", $env_content);
            $env_content = preg_replace('/DB_USERNAME=.*/', "DB_USERNAME='$this->db_username'", $env_content);
            $env_content = preg_replace('/DB_PASSWORD=.*/', "DB_PASSWORD='$this->db_password'", $env_content);

            config([
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

            Status::create([
                'name' => 'active',
                'displayName' => 'Aktív'
            ]);

            Status::create([
                'name' => 'inactive',
                'displayName' => 'Inaktív'
            ]);

            //alapértelmezett rendszergazda fiók létrehozása
            if (!config('app.installed')) {

                $user_data['name'] = $this->admin_name | $this->admin_username;
                $user_data['username'] = $this->admin_username;
                $user_data['email'] = $this->admin_email;
                $user_data['password'] = Hash::make($this->password);
                $user_data['is_admin'] = true;

                $user = User::create($user_data);

                Auth::login($user);
            }

            $env_content = preg_replace('/APP_INSTALLED=.*/', "APP_INSTALLED=true", $env_content);

            config([
                'app.installed' => true
            ]);

            file_put_contents(
                base_path('.env'),
                $env_content
            );

            return $this->redirect('/', navigate: true);
        } catch (Exception $err) {
            $this->addError('save_error', $err->getMessage());

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
        return view('livewire.setup.initial-setup')->layout('layouts.guest');
    }
}
