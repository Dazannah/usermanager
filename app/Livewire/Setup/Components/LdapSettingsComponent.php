<?php

namespace App\Livewire\Setup\Components;

use Exception;
use Livewire\Component;
use LdapRecord\Connection;
use App\Settings\LdapSettings;
use Illuminate\Validation\ValidationException;

class LdapSettingsComponent extends Component {

    protected LdapSettings $ldap_settings;

    public bool $ldap_active;
    public string|null $ldap_host;
    public string|null $ldap_base_dn;
    public string|null $ldap_port;
    public string|null $ldap_username;
    public string|null $ldap_password;

    private string $domain;
    private string $user_principal_name;

    public function __construct() {
        $this->ldap_settings = ldap_settings();
    }

    public function mount() {
        $this->ldap_active = $this->ldap_settings->active;
        $this->ldap_host = $this->ldap_settings->host;
        $this->ldap_base_dn = $this->ldap_settings->base_dn;
        $this->ldap_port = $this->ldap_settings->port;
        $this->ldap_username = explode('@', $this->ldap_settings->username)[0];
        $this->ldap_password = $this->ldap_settings->password;
    }

    protected $rules = [
        'ldap_host' => 'required_if:ldap_active,===,true',
        'ldap_base_dn' => 'required_if:ldap_active,==,true',
        'ldap_port' => 'required_if:ldap_active,==,true|integer|min:1|max:65535',
        'ldap_username' => 'required_if:ldap_active,==,true',
        'ldap_password' => 'required_if:ldap_active,==,true'
    ];

    protected $messages = [
        'ldap_host.required_if' => 'Szerver cím megadása kötelező.',
        'ldap_base_dn.required_if' => 'Base DN megadása kötelező.',
        'ldap_base_dn.regex' => 'Megfelelő formátum: dc=local,dc=com',
        'ldap_port.required_if' => 'Port megadása kötelező.',
        'ldap_port.integer' => 'A portnak egész számnak kell lennie.',
        'ldap_port.min' => 'Az LDAP port minimum 1 lehet.',
        'ldap_port.max' => 'Az LDAP port maximum 65535 lehet.',
        'ldap_username.required_if' => 'Felhasználónév megadása kötelező.',
        'ldap_password.required_if' => 'Jelszó megadása kötelező.',
    ];

    public function test_ldap_connection() {
        try {
            $this->validate($this->rules, $this->messages);

            $this->base_dn_to_domain();
            $this->generate_userPrincipalName();

            $connection = new Connection([
                // Mandatory Configuration Options
                'hosts'            => [$this->ldap_host],
                'base_dn'          => $this->ldap_base_dn,
                'username'         => $this->user_principal_name,
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

            config([
                'ldap.connections.default.hosts' => $this->ldap_host,
                'ldap.connections.default.port' => $this->ldap_port,
                'ldap.connections.default.base_dn' => $this->ldap_base_dn,
                'ldap.connections.default.username' => $this->user_principal_name,
                'ldap.connections.default.password' => $this->ldap_password
            ]);

            session()->flash('ldap_test_result', "Sikeres LDAP kapcsolat.");
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('ldap_test_result_error', $err->getMessage());
        }
    }

    public function save_ldap() {
        try {
            $this->test_ldap_connection();

            $this->ldap_settings->active = $this->ldap_active;
            $this->ldap_settings->host = $this->ldap_host;
            $this->ldap_settings->base_dn = $this->ldap_base_dn;
            $this->ldap_settings->port = $this->ldap_port;
            $this->ldap_settings->username = $this->user_principal_name;
            $this->ldap_settings->password = $this->ldap_password;

            $this->ldap_settings->save();

            $this->dispatch('save_ldap_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('save_ldap_error', $err->getMessage());
        }
    }

    private function base_dn_to_domain() {
        $parts = explode(',', $this->ldap_base_dn);

        $this->domain = collect($parts)->map(fn($part) => substr($part, 3))->implode('.');
    }

    private function generate_userPrincipalName() {
        $this->user_principal_name = $this->ldap_username . '@' . $this->domain;
    }

    public function render() {
        return view('livewire.setup.components.ldap-settings-component');
    }
}
