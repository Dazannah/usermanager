<?php

namespace App\Livewire\Admin\Components;

use Exception;
use App\Models\Column;
use App\Models\Status;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

class CreateColumn extends Component {
    public $statuses;

    // new column
    public $column_display_name;
    public $column_status_id = 1;
    public $column_position;

    public function save_column() {
        try {
            $rules = [
                'column_display_name' => 'required',
                'column_status_id' => 'required'
            ];

            $messages = [
                'column_display_name.required' => 'Elnevezés kitöltése kötelező',
                'column_status_id.required' => 'Egy státuszt ki kell választani'
            ];

            $this->validate($rules, $messages);

            $column = Column::orderBy('position', 'desc')->first();

            $column = new Column([
                'displayName' => $this->column_display_name,
                'status_id' => $this->column_status_id,
                'position' => $column?->position + 1 ?? 1
            ]);

            $column->save();

            $this->reset('column_display_name', 'column_status_id');
            $this->dispatch('refresh_authorization_mount');
            $this->dispatch('columns_save_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('save_column_error', $err->getMessage());

            $this->dispatch('refresh_authorization_mount');
        }
    }

    public function render() {
        return view('livewire.admin.components.create-column');
    }
}
