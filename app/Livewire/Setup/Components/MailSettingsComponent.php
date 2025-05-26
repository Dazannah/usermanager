<?php

namespace App\Livewire\Setup\Components;

use Exception;
use App\Mail\MailTest;
use Livewire\Component;
use App\Settings\MailSettings;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Mailer\Exception\TransportException;

class MailSettingsComponent extends Component {
    protected MailSettings $mail_settings;

    public string|null $mail_host;
    public int|null $mail_port;
    public string|null $mail_username;
    public string|null $mail_password;
    public string|null $mail_test_address;

    public bool $is_password_set = false;

    protected $rules = [
        'mail_host' => 'required',
        'mail_port' => 'required|integer|min:1|max:65535',
        'mail_username' => 'required|email',
        //'mail_password' => 'required',
        'mail_test_address' => 'required|email',
    ];

    protected $messages = [
        'mail_host.required' => 'Email szerver címe megadása kötelező.',
        'mail_port.required' => 'SMTP Port megadása kötelező.',
        'mail_port.integer' => 'Az SMTP Portnak egész számnak kell lennie.',
        'mail_port.min' => 'Az SMTP Port minimum 1 lehet.',
        'mail_port.max' => 'Az SMTP Port maximum 65535 lehet.',
        'mail_username.required' => 'Email cím megadása kötelező.',
        'mail_username.email' => 'Nem megfelelő formátum.',
        'mail_password.required' => 'Jelszó megadása kötelező.',
        'mail_test_address.required' => 'Teszt címzet megadása kötelező.',
        'mail_test_address.email' => 'Nem megfelelő formátum.',
    ];

    public function __construct() {
        $this->mail_settings = mail_settings();
    }

    public function mount() {
        $this->mail_host = $this->mail_settings->host;
        $this->mail_port = $this->mail_settings->port;
        $this->mail_username = $this->mail_settings->username;

        $this->is_password_set = !empty($this->mail_settings->password);
    }

    public function test_mail_connection_standalone() {
        try {
            $this->test_mail_connection();
        } catch (ValidationException $err) {
            throw $err;
        } catch (TransportException $err) {
            $err_message = $err->getMessage();

            if ($err->getCode() === 535)
                $this->addError('mail_test_result_error', "Hibás felhasználónév vagy jelszó. Részletek: $err_message");

            if ($err->getCode() === 0)
                $this->addError('mail_test_result_error', "Kapcsolat létesítése sikertelen. Részletek: $err_message");

            $this->addError('mail_test_result_error', $err_message);
        } catch (Exception $err) {
            $this->addError('mail_test_result_error', $err->getMessage());
        }
    }

    public function test_mail_connection() {

        $this->validate($this->rules, $this->messages);

        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.host' => $this->mail_host,
            'mail.mailers.smtp.port' => $this->mail_port,
            'mail.mailers.smtp.username' => $this->mail_username,
            'mail.mailers.smtp.password' => empty($this->mail_password) ? $this->mail_settings->password : $this->mail_password,
            'mail.from.address' => $this->mail_username,
            'mail.from.name' => app_settings()->app_name,
        ]);

        $test_mail = new MailTest(app_settings()->app_name);

        Mail::to($this->mail_test_address)->send($test_mail);

        session()->flash('mail_test_result', "Sikeres levél küldés.");
    }

    public function save_mail() {
        try {
            $this->test_mail_connection();

            $this->mail_settings->host = $this->mail_host;
            $this->mail_settings->port = $this->mail_port;
            $this->mail_settings->username = $this->mail_username;
            $this->mail_settings->password = empty($this->mail_password) ? $this->mail_settings->password : $this->mail_password;

            $this->mail_settings->save();

            $this->dispatch('save_mail_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('save_mail_error', $err->getMessage());
        }
    }


    public function render() {
        return view('livewire.setup.components.mail-settings-component');
    }
}
