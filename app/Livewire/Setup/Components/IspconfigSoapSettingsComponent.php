<?php

namespace App\Livewire\Setup\Components;

use Exception;
use SoapClient;
use Livewire\Component;
use App\Settings\IspconfigSoapSettings;
use Illuminate\Validation\ValidationException;
use SoapFault;

class IspconfigSoapSettingsComponent extends Component {
    protected IspconfigSoapSettings $ispconfig_soap_settings;

    public bool $ispfonfig_active;
    public string|null $uri;
    public string|null $location;
    public string|null $username;
    public string|null $password;

    public $rules = [
        'uri' => 'required_if:ispfonfig_active,==,true',
        'location' => 'required_if:ispfonfig_active,==,true',
        'username' => 'required_if:ispfonfig_active,==,true',
        'password' => 'required_if:ispfonfig_active,==,true',
    ];
    public $messages = [
        'uri.required_if' => 'ISPConfig szerver cím megadása kötelező.',
        'location.required_if' => 'ISPConfig soap hely megadása kötelező.',
        'username.required_if' => 'Felhasználónév megadása kötelező.',
        'password.required_if' => 'Jelszó megadása kötelező.',
    ];

    public function __construct() {
        $this->ispconfig_soap_settings = ispconfig_soap_settings();
    }

    public function mount() {
        $this->ispfonfig_active = $this->ispconfig_soap_settings->active;
        $this->uri = $this->ispconfig_soap_settings->uri;
        $this->location = $this->ispconfig_soap_settings->location;
        $this->username = $this->ispconfig_soap_settings->username;
        $this->password = $this->ispconfig_soap_settings->password;
    }

    public function test_ispconfig_connection_standalone() {
        try {
            $this->test_ispconfig_connection();
        } catch (ValidationException $err) {
            throw $err;
        } catch (SoapFault $err) {
            $this->handle_soap_error($err);
        } catch (Exception $err) {
            $this->addError('ispconfig_test_result_error', $err->getMessage());
        }
    }

    public function test_ispconfig_connection() {

        $this->validate($this->rules, $this->messages);

        $arrContextOptions = stream_context_create(array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            )
        ));

        $soap_client = new SoapClient(null, array(
            'uri'      => $this->uri,
            'location' => $this->location,
            'trace' => 1,
            'exceptions' => 1,
            "stream_context" => $arrContextOptions

        ));

        $soap_client->login($this->username, $this->password);

        session()->flash('ispconfig_test_result', "Sikeres bejelentkezés.");
    }

    public function save_ispconfig() {
        try {
            $this->test_ispconfig_connection();

            $this->ispconfig_soap_settings->active = $this->ispfonfig_active;
            $this->ispconfig_soap_settings->uri = $this->uri;
            $this->ispconfig_soap_settings->location = $this->location;
            $this->ispconfig_soap_settings->username = $this->username;
            $this->ispconfig_soap_settings->password = $this->password;

            $this->ispconfig_soap_settings->save();

            $this->dispatch("save_ispconfig_success");
        } catch (ValidationException $err) {
            throw $err;
        } catch (SoapFault $err) {
            $this->handle_soap_error($err);
        } catch (Exception $err) {
            $this->addError('ispconfig_test_result_error', $err->getMessage());
        }
    }

    private function handle_soap_error(SoapFault $err) {
        if ($err->faultcode == "HTTP")
            $this->addError('ispconfig_test_result_error', "Nemsikerűlt kapcsolódni a szerverhez.");

        if ($err->faultcode == "login_failed")
            $this->addError('ispconfig_test_result_error', "Felhasználónév vagy jelszó helytelen.");

        $this->addError('ispconfig_test_result_error', $err->getMessage());
    }

    public function render() {
        return view('livewire.setup.components.ispconfig-soap-settings-component');
    }
}
