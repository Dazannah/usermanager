<?php

namespace App\Livewire\Setup\Components;

use App\Settings\AppSettings;
use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Artisan;

class AppSettingsComponent extends Component {
    use WithFileUploads;

    protected AppSettings $app_settings;

    public string $app_name;
    public $logo;

    public $logo_rules = [
        'logo' => 'image',
    ];

    public $logo_messages = [
        'logo.required' => 'Logo feltöltése kötelező.',
        'logo.image' => 'A logonak képnek kell lennie.'
    ];

    public $app_name_rules = [
        'app_name' => 'required'
    ];

    public $app_name_messages = [
        'app_name.required' => 'Alkalmazás neve megadása kötelező.'
    ];

    public $listeners = ['save_general'];

    public function __construct() {
        $this->app_settings = app(AppSettings::class);
    }

    public function mount() {
        $this->app_name = $this->app_settings->app_name;
    }

    public function save_general() {
        try {
            if (isset($this->logo)) {
                $this->validate($this->logo_rules, $this->logo_messages);
                $filename_with_extension = 'logo.' . $this->logo->extension();

                $this->app_settings->logo_name = $filename_with_extension;

                $this->logo->storeAs(path: '', name: $filename_with_extension, options: 'public');
                Artisan::call('storage:link');
            }

            $this->validate($this->app_name_rules, $this->app_name_messages);

            $this->app_settings->app_name = $this->app_name;
            $this->app_settings->save();


            $this->dispatch('app-name-updated', $this->app_settings->app_name);



            $this->dispatch('save_general_success');
        } catch (Exception $err) {
            $this->addError('save_general_error', $err->getMessage());
        }
    }

    public function render() {
        return view('livewire.setup.components.app-settings-component');
    }
}
