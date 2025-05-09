<?php

namespace App\Livewire;

use Exception;
use App\Models\User;
use App\Mail\MailTest;
use Livewire\Component;
use LdapRecord\Connection;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rules;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;

class InitialSetup extends Component {
    use WithFileUploads;

    public $app_name = 'Felhasználó kezelő';
    // public $logo;

    public $mail_host = '';
    public $mail_port = 465;
    public $mail_username = '';
    public $mail_password = '';
    public $mail_test_address = '';

    public $db_host = '';
    public $db_port = 3306;
    public $db_databasename = '';
    public $db_username = '';
    public $db_password = '';

    public $admin_name = '';
    public $admin_username = 'admin';
    public $admin_email = '';
    public $password = '';
    public $password_confirmation = '';

    public $ldap_active = true;
    public $ldap_host = '';
    public $ldap_base_dn = '';
    public $ldap_port = 389;
    public $ldap_username = '';
    public $ldap_password = '';

    private $domain = '';
    private $userPrincipalName = '';

    protected $rules = [
        'app_name' => 'required',
        //'logo' => 'required|image|max:2048',
        'db_host' => 'required',
        'db_port' => 'required|integer|min:1|max:65535',
        'db_databasename' => 'required',
        'db_username' => 'required',
        'db_password' => 'required',
        'admin_name' => 'max:255',
        'admin_username' => 'required|max:255',
        'admin_email' => 'required|email|max:255',
        'password' => 'required|confirmed',
        'ldap_host' => 'required',
        'ldap_port' => 'required',
        'ldap_base_dn' => 'required',
        'ldap_username' => 'required',
        'ldap_password' => 'required'
    ];

    protected $messages = [
        'app_name.required' => 'Alkalmazás név megadása körtelező.',
        // 'logo.required' => 'Logo feltöltése kötelező.',
        // 'logo.image' => 'A logonak képnek kell lennie.',
        // 'logo.max' => 'Maximum méret 10MB',
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
        'ldap_base_dn.required' => 'LDAP DN megadása kötelező.',
        'ldap_username.required' => 'LDAP felhasználónév megadása kötelező.',
        'ldap_password.required' => 'LDAP felhasználó jelszó megadása kötelező.',
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function toggle_ldap_active() {
        $this->ldap_active = !$this->ldap_active;
    }

    private function base_dn_to_domain() {
        $parts = explode(',', $this->ldap_base_dn);

        $this->domain = collect($parts)->map(fn($part) => substr($part, 3))->implode('.');
    }

    private function generate_userPrincipalName() {
        $this->userPrincipalName = $this->ldap_username . '@' . $this->domain;
    }

    public function test_mail_connection() {
        try {
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.host' => $this->mail_host,
                'mail.mailers.smtp.port' => $this->mail_port,
                'mail.mailers.smtp.username' => $this->mail_username,
                'mail.mailers.smtp.password' => $this->mail_password,
                'mail.from.address' => $this->mail_username,
                'mail.from.name' => $this->app_name,
            ]);

            $test_mail = new MailTest($this->app_name);

            Mail::to($this->mail_test_address)->send($test_mail);

            return true;
        } catch (Exception $err) {
            return $err->getMessage();
        }
    }

    public function test_mail_connection_standalone() {
        $result = $this->test_mail_connection();

        if ($result === true) {
            session()->flash('mail_test_result', "Sikeres levél küldés.");

            return;
        } else {
            $this->addError('mail_test_result_error', $result);

            return;
        }
    }

    public function test_ldap_connection() {
        $this->validate();

        $this->base_dn_to_domain();
        $this->generate_userPrincipalName();

        try {
            $connection = new Connection([
                // Mandatory Configuration Options
                'hosts'            => [$this->ldap_host],
                'base_dn'          => $this->ldap_base_dn,
                // 'username'         => $this->ldap_username,
                // 'password'         => $this->ldap_password,

                // Optional Configuration Options
                'port'             => $this->ldap_port,
                'use_ssl'          => false,
                'use_tls'          => false,
                'version'          => 3,
                'timeout'          => 5,
                'follow_referrals' => false,
            ]);

            $connection->connect();
            $user_atuh = $connection->auth()->attempt($this->userPrincipalName, $this->ldap_password);

            if (!$user_atuh)
                throw new Exception("Felhasználó adatok helytelenek.");

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

        //ldap setup test before save
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

            //general configs
            $env_content = preg_replace('/\nAPP_NAME=.*/', "\nAPP_NAME=" . "'$this->app_name'", $env_content);
            $env_content = preg_replace('/APP_INSTALLED=.*/', "APP_INSTALLED=true", $env_content);
            $env_content = preg_replace('/SESSION_DRIVER=.*/', "SESSION_DRIVER=database", $env_content);

            config([
                'app.name' => $this->app_name,
                'app.installed' => true,
                'session.driver' => 'database',
            ]);

            //mailer configs
            $env_content = preg_replace('/\nMAIL_MAILER=.*/', "\nMAIL_MAILER=" . "smtp", $env_content);
            $env_content = preg_replace('/\nMAIL_HOST=.*/', "\nMAIL_HOST=" . "'$this->mail_host'", $env_content);
            $env_content = preg_replace('/\nMAIL_PORT=.*/', "\nMAIL_PORT=" . "'$this->mail_port'", $env_content);
            $env_content = preg_replace('/\nMAIL_USERNAME=.*/', "\nMAIL_USERNAME=" . "'$this->mail_username'", $env_content);
            $env_content = preg_replace('/\nMAIL_PASSWORD=.*/', "\nMAIL_PASSWORD=" . "'$this->mail_password'", $env_content);
            $env_content = preg_replace('/\nMAIL_FROM_ADDRESS=.*/', "\nMAIL_FROM_ADDRESS=" . "'$this->mail_username'", $env_content);

            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.host' => $this->mail_host,
                'mail.mailers.smtp.port' => $this->mail_port,
                'mail.mailers.smtp.username' => $this->mail_username,
                'mail.mailers.smtp.password' => $this->mail_password,
                'mail.from.address' => $this->mail_username,
                'mail.from.name' => $this->app_name,
            ]);

            //database configs
            $env_content = preg_replace('/\nDB_HOST=.*/', "\nDB_HOST=" . "'$this->db_host'", $env_content);
            $env_content = preg_replace('/\nDB_PORT=.*/', "\nDB_PORT=" . "'$this->db_port'", $env_content);
            $env_content = preg_replace('/\nDB_DATABASE=.*/', "\nDB_DATABASE=" . "'$this->db_databasename'", $env_content);
            $env_content = preg_replace('/\nDB_USERNAME=.*/', "\nDB_USERNAME=" . "'$this->db_username'", $env_content);
            $env_content = preg_replace('/\nDB_PASSWORD=.*/', "\nDB_PASSWORD=" . "'$this->db_password'", $env_content);

            config([
                'database.connections.mysql.host' => $this->db_host,
                'database.connections.mysql.port' => $this->db_port,
                'database.connections.mysql.database' => $this->db_databasename,
                'database.connections.mysql.username' => $this->db_username,
                'database.connections.mysql.password' => $this->db_password
            ]);


            //ldap configs
            if ($this->ldap_active === true) {
                $env_content = preg_replace('/LDAP_HOST=.*/', "LDAP_HOST=" . "'$this->ldap_host'", $env_content);
                $env_content = preg_replace('/LDAP_USERNAME=.*/', "LDAP_USERNAME=" . "'$this->userPrincipalName'", $env_content);
                $env_content = preg_replace('/LDAP_PASSWORD=.*/', "LDAP_PASSWORD=" . "'$this->ldap_password'", $env_content);
                $env_content = preg_replace('/LDAP_PORT=.*/', "LDAP_PORT=" . $this->ldap_port, $env_content);
                $env_content = preg_replace('/LDAP_BASE_DN=.*/', "LDAP_BASE_DN=" . "'$this->ldap_base_dn'", $env_content);
            }

            config([
                'ldap.connections.default.hosts' => $this->ldap_host,
                'ldap.connections.default.port' => $this->ldap_port,
                'ldap.connections.default.base_dn' => $this->ldap_base_dn,
                'ldap.connections.default.username' => $this->userPrincipalName,
                'ldap.connections.default.password' => $this->ldap_password
            ]);

            //adatbázis migráció
            Artisan::call('migrate', array(
                '--path' => 'database/migrations',
                '--database' => 'mysql',
                '--force' => true
            ));

            //alapértelmezett rendszergazda fiók létrehozása
            $user_data['name'] = $this->admin_name | $this->admin_username;
            $user_data['username'] = $this->admin_username;
            $user_data['email'] = $this->admin_email;
            $user_data['password'] = Hash::make($this->password);

            $user = User::create($user_data);

            Auth::login($user);

            file_put_contents(
                base_path('.env'),
                $env_content
            );

            //$this->logo->storeAs(path: 'imgs', name: 'logo');

            return redirect()->to('/');
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
        return view('livewire.initial-setup')->layout('layouts.guest');
    }
}
