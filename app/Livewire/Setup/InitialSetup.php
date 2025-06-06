<?php

namespace App\Livewire\Setup;

use Exception;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\AuthorizationLevelService;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;

class InitialSetup extends Component {
    public $admin_name;
    public $admin_username;
    public $admin_email;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'admin_name' => 'max:255',
        'admin_username' => 'required|max:255',
        'admin_email' => 'max:255',
        'password' => 'required|confirmed',
    ];

    protected $messages = [
        'admin_username.required' => 'Admin felhasználónév megadása kötelező.',
        'admin_username.max' => 'Admin felhasználónév túl hosszú.',
        //'admin_email.required' => 'Admin email cím megadása kötelező.',
        //'admin_email.email' => 'Email cím megadása kötelező.',
        'password.required' => 'Admin jelszó megadása kötelező.',
        'password.confirmed' => 'Megadott jelszavak nem egyeznek.',
    ];

    public function save_admin() {
        $this->validate($this->rules, $this->messages);
        if (config('ldap.active')) {
            $user = LdapUser::where('samaccountname', '=', $this->admin_username)->first();

            if ($user?->exists) {
                $this->addError('save_error', "Létezik ilyen felhasználónévvel LDAP felhasználó.");

                return;
            }
        }

        //sikeres validáció után .env módosítása és mentése
        $original_env_content = file_get_contents(base_path('.env'));

        try {
            //alapértelmezett rendszergazda fiók létrehozása
            $user = User::create([
                'name' => $this->admin_name ?? $this->admin_username,
                'username' => $this->admin_username,
                'email' => $this->admin_email,
                'password' => Hash::make($this->password),
                'auth_level' => AuthorizationLevelService::get_sys_admin_level(),
                'is_local' => true
            ]);

            Auth::login($user);

            //set env
            $this->set_installed(true);

            $this->dispatch('save_admin_success');

            return $this->redirect('/', navigate: true);
        } catch (Exception $err) {
            $this->addError('save_error', $err->getMessage());

            //hiba esetén a változatlan .env vissza töltése
            file_put_contents(
                base_path('.env'),
                $original_env_content
            );
        }
    }

    public function set_installed($is_installed) {
        $env_content = file_get_contents(base_path('.env'));

        $env_content = preg_replace('/APP_INSTALLED=.*/', "APP_INSTALLED=true", $env_content);

        config([
            'app.installed' => $is_installed
        ]);

        file_put_contents(
            base_path('.env'),
            $env_content
        );
    }

    public function render() {
        if (!config('app.is_local_account_eneabled')) {
            $this->set_installed(true);
            $this->redirect('/');
        }

        return view('livewire.setup.initial-setup')->layout('layouts.guest');
    }
}
