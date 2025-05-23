<?php

namespace App\Livewire\Setup\Components;

use App\Models\Config;
use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Artisan;

class Logo extends Component {
    use WithFileUploads;

    public $logo;

    public $rules = [
        'logo' => 'required|image',
    ];

    public $messages = [
        'logo.required' => 'Logo feltöltése kötelező.',
        'logo.image' => 'A logonak képnek kell lennie.'
    ];

    public $listeners = ['save_logo'];

    public function save_logo() {
        try {
            $this->validate($this->rules, $this->messages);

            $filename_with_extension = 'logo.' . $this->logo->extension();

            $logo_config = Config::where('name', '=', 'app.logo_name')->first() ?? $config = new Config(
                [
                    'name' => 'app.logo_name'
                ]
            );

            $logo_config->value = $filename_with_extension;

            $this->logo->storeAs(path: '', name: $filename_with_extension, options: 'public');
            $logo_config->save();

            Artisan::call('storage:link');

            $this->dispatch('logo_save_success');
        } catch (Exception $err) {
            $this->addError('save_logo_error', $err->getMessage());
        }
    }

    public function render() {
        return view('livewire.setup.components.logo');
    }
}
