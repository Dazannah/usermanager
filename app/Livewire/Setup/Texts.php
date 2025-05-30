<?php

namespace App\Livewire\Setup;

use Livewire\Component;
use Livewire\Attributes\Url;
use App\Settings\TextSettings;
use Exception;

class Texts extends Component {

    private TextSettings $text_settings;

    public string $departmentNumber;
    public string $departmentNumber2;

    public $listeners = ['mount'];


    public function __construct() {
        $this->text_settings = texts_settings();
    }

    public function mount() {
        $this->departmentNumber = $this->text_settings->departmentNumber;
        $this->departmentNumber2 = $this->text_settings->departmentNumber2;
    }

    public function save_texts() {
        try {
            $this->text_settings->departmentNumber = $this->departmentNumber;
            $this->text_settings->departmentNumber2 = $this->departmentNumber2;

            $this->text_settings->save();

            $this->dispatch('save_texts_success');
            $this->dispatch('mount');
        } catch (Exception $err) {
            $this->addError('error', $err->getMessage());
        }
    }

    public function render() {
        return view('livewire.setup.texts')->layout('layouts.admin');
    }
}
