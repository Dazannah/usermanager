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
    public string $primary_color;
    public string $secondary_color;

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

    public $color_rules = [
        'primary_color' => [
            'required',
            'regex:/^([a-f0-9]{6}|[a-f0-9]{3})$/i'
        ],
        'secondary_color' => [
            'required',
            'regex:/^([a-f0-9]{6}|[a-f0-9]{3})$/i'
        ]
    ];

    public $color_messages = [
        'primary_color.required' => 'Elsődleges szín megadása kötelező.',
        'primary_color.regex' => 'Elsődleges színt hexadecimális formátumban kell megadni.',
        'secondary_color.required' => 'Másodlagos szín megadása kötelező.',
        'secondary_color.regex' => 'Másodlagos színt hexadecimális formátumban kell megadni.'
    ];

    public $listeners = ['save_general'];

    public function __construct() {
        $this->app_settings = app_settings();
    }

    public function mount() {
        $this->app_name = $this->app_settings->app_name;
        $this->primary_color = $this->app_settings->primary_color;
        $this->secondary_color = $this->app_settings->secondary_color;
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

            $this->validate($this->color_rules, $this->color_messages);
            $this->app_settings->primary_color = $this->primary_color;
            $this->app_settings->secondary_color = $this->secondary_color;

            $this->app_settings->save();


            $this->dispatch('app-updated');

            $this->dispatch('save_general_success');
        } catch (Exception $err) {
            $this->addError('save_general_error', $err->getMessage());
        }
    }

    public function render() {
        return view('livewire.setup.components.app-settings-component');
    }

    public function delete_logo() {
        $this->app_settings->logo_name = null;
        $this->app_settings->save();
    }
}
