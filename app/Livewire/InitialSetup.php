<?php

namespace App\Livewire;

use SoapClient;
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

    public $app_name;
    // public $logo;

    public $mail_host;
    public $mail_port;
    public $mail_username;
    public $mail_password;
    public $mail_test_address;

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

    public $ldap_active;
    public $ldap_host;
    public $ldap_base_dn;
    public $ldap_port;
    public $ldap_username;
    public $ldap_password;

    public $ispfonfig_active;
    public $ispconfig_soap_uri;
    public $ispconfig_soap_location;
    public $ispconfig_soap_remote_username;
    public $ispconfig_soap_remote_user_password;

    private $domain;
    private $userPrincipalName;

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
        'ldap_host.string' => 'LDAP szerver cím megadása kötelező.'
    ];

    public function mount() {
        $this->app_name = config('app.name');

        $this->mail_host = config('mail.mailers.smtp.host');
        $this->mail_port = config('mail.mailers.smtp.port');
        $this->mail_username = config('mail.mailers.smtp.username');
        $this->mail_password = config('mail.mailers.smtp.password');
        $this->mail_test_address = '';

        $this->db_host = config('database.connections.mysql.host');
        $this->db_port = config('database.connections.mysql.port');
        $this->db_databasename = config('database.connections.mysql.database');
        $this->db_username = config('database.connections.mysql.username');
        $this->db_password = config('database.connections.mysql.password');

        $this->admin_name = '';
        $this->admin_username = 'usermanager_admin';
        $this->admin_email = '';
        $this->password = '';
        $this->password_confirmation = '';

        $this->ldap_active = config('ldap.connections.active');
        $this->ldap_host = config('ldap.connections.default.hosts')[0];
        $this->ldap_base_dn = config('ldap.connections.default.base_dn');
        $this->ldap_port = config('ldap.connections.default.port');
        $this->ldap_username = config('ldap.connections.default.username');
        $this->ldap_password = config('ldap.connections.default.password');

        $this->ispfonfig_active = config('ispconfig.soap.active');
        $this->ispconfig_soap_uri = config('ispconfig.soap.connection.uri');
        $this->ispconfig_soap_location = config('ispconfig.soap.connection.location');
        $this->ispconfig_soap_remote_username = config('ispconfig.soap.connection.username');
        $this->ispconfig_soap_remote_user_password = config('ispconfig.soap.connection.password');
    }

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function toggle_ldap_active() {
        $this->ldap_active = !$this->ldap_active;
    }

    public function toggle_ispfonfig_active() {
        $this->ispfonfig_active = !$this->ispfonfig_active;
    }

    private function base_dn_to_domain() {
        $parts = explode(',', $this->ldap_base_dn);

        $this->domain = collect($parts)->map(fn($part) => substr($part, 3))->implode('.');
    }

    private function generate_userPrincipalName() {
        $this->userPrincipalName = $this->ldap_username . '@' . $this->domain;
    }

    public function test_ispconfig_connection() {
        try {
            $arrContextOptions = stream_context_create(array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                )
            ));

            $soap_client = new SoapClient(null, array(
                'uri'      => $this->ispconfig_soap_uri,
                'location' => $this->ispconfig_soap_location,
                'trace' => 1,
                'exceptions' => 1,
                "stream_context" => $arrContextOptions

            ));

            $soap_client->login($this->ispconfig_soap_remote_username, $this->ispconfig_soap_remote_user_password);

            return true;
        } catch (Exception $err) {
            return $err->getMessage();
        }
    }

    public function test_ispconfig_connection_standalone() {
        $result = $this->test_ispconfig_connection();

        if ($result === true) {
            session()->flash('ispconfig_test_result', "Sikeres bejelentkezés.");

            return;
        } else {
            $this->addError('ispconfig_test_result_error', $result);

            return;
        }
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

    public function test_ldap_connection(bool $test_admin_user) {
        $this->base_dn_to_domain();
        $this->generate_userPrincipalName();

        try {
            $connection = new Connection([
                // Mandatory Configuration Options
                'hosts'            => [$this->ldap_host],
                'base_dn'          => $this->ldap_base_dn,
                'username'         => $this->userPrincipalName,
                'password'         => $this->ldap_password,

                // Optional Configuration Options
                'port'             => $this->ldap_port,
                'use_ssl'          => false,
                'use_tls'          => false,
                'version'          => 3,
                'timeout'          => 5,
                'follow_referrals' => false,
            ]);

            $connection->connect();

            if ($test_admin_user) {
                $result = $connection->query()->where('samaccountname', '=', $this->admin_username)->first();

                if ($result !== null)
                    throw new Exception("Már létezik egy LDAP-felhasználó az alapértelmezett rendszergazda felhasználónévvel: $this->admin_username.  Kérlek, adj meg egy másikat.");
            }

            return true;
        } catch (Exception $err) {
            return $err->getMessage();
        }
    }

    public function test_ldap_connection_standalone() {
        $result = $this->test_ldap_connection(false);

        if ($result === true) {
            session()->flash('ldap_test_result', "Sikeres kapcsolat kiépítés.");

            return;
        } else {
            $this->addError('ldap_test_result_error', $result);

            return;
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

        //ldap setup test before save
        if ($this->ldap_active === true) {
            //test_admin_user flag set true
            $ldap_test_result = $this->test_ldap_connection(true);

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
            $env_content = preg_replace('/APP_NAME=.*/', "APP_NAME='$this->app_name'", $env_content);
            $env_content = preg_replace('/APP_INSTALLED=.*/', "APP_INSTALLED=true", $env_content);
            $env_content = preg_replace('/SESSION_DRIVER=.*/', "SESSION_DRIVER=database", $env_content);

            config([
                'app.name' => $this->app_name,
                'app.installed' => true,
                'session.driver' => 'database',
            ]);

            //mailer configs
            $env_content = preg_replace('/MAIL_MAILER=.*/', "MAIL_MAILER=smtp", $env_content);
            $env_content = preg_replace('/MAIL_HOST=.*/', "MAIL_HOST='$this->mail_host'", $env_content);
            $env_content = preg_replace('/MAIL_PORT=.*/', "MAIL_PORT='$this->mail_port'", $env_content);
            $env_content = preg_replace('/MAIL_USERNAME=.*/', "MAIL_USERNAME='$this->mail_username'", $env_content);
            $env_content = preg_replace('/MAIL_PASSWORD=.*/', "MAIL_PASSWORD='$this->mail_password'", $env_content);
            $env_content = preg_replace('/MAIL_FROM_ADDRESS=.*/', "MAIL_FROM_ADDRESS='$this->mail_username'", $env_content);

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


            //ldap configs
            if ($this->ldap_active === true) {
                $env_content = preg_replace('/LDAP_HOST=.*/', "LDAP_HOST='$this->ldap_host'", $env_content);
                $env_content = preg_replace('/LDAP_USERNAME=.*/', "LDAP_USERNAME='$this->userPrincipalName'", $env_content);
                $env_content = preg_replace('/LDAP_PASSWORD=.*/', "LDAP_PASSWORD='$this->ldap_password'", $env_content);
                $env_content = preg_replace('/LDAP_PORT=.*/', "LDAP_PORT='$this->ldap_port'", $env_content);
                $env_content = preg_replace('/LDAP_BASE_DN=.*/', "LDAP_BASE_DN='$this->ldap_base_dn'", $env_content);

                config([
                    'ldap.connections.default.hosts' => $this->ldap_host,
                    'ldap.connections.default.port' => $this->ldap_port,
                    'ldap.connections.default.base_dn' => $this->ldap_base_dn,
                    'ldap.connections.default.username' => $this->userPrincipalName,
                    'ldap.connections.default.password' => $this->ldap_password
                ]);
            }

            //ispconfig soap configs
            if ($this->ispfonfig_active === true) {
                $env_content = preg_replace('/ISPCONFIG_SOAP_ACTIVE=.*/', "ISPCONFIG_SOAP_ACTIVE=true", $env_content);
                $env_content = preg_replace('/ISPCONFIG_SOAP_URI=.*/', "ISPCONFIG_SOAP_URI='$this->ispconfig_soap_uri'", $env_content);
                $env_content = preg_replace('/ISPCONFIG_SOAP_LOCATION=.*/', "ISPCONFIG_SOAP_LOCATION='$this->ispconfig_soap_location'", $env_content);
                $env_content = preg_replace('/ISPCONFIG_SOAP_USERNAME=.*/', "ISPCONFIG_SOAP_USERNAME='$this->ispconfig_soap_remote_username'", $env_content);
                $env_content = preg_replace('/ISPCONFIG_SOAP_PASSWORD=.*/', "ISPCONFIG_SOAP_PASSWORD='$this->ispconfig_soap_remote_user_password'", $env_content);

                config([
                    'ispconfig.soap.uri' => $this->ispconfig_soap_uri,
                    'ispconfig.soap.location' => $this->ispconfig_soap_location,
                    'ispconfig.soap.username' => $this->ispconfig_soap_remote_username,
                    'ispconfig.soap.password' => $this->ispconfig_soap_remote_user_password
                ]);
            }

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
            $user_data['is_admin'] = true;

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
