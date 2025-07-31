<?php

namespace App\Livewire\Forms;

use Exception;
use Livewire\Form;
use App\Models\Column;
use Illuminate\Support\Facades\DB;

class ColumnForm extends Form {
    // livewire view properties
    public Column|null $column;

    public string|null $displayName;
    public int $status_id = 1;
    public int|null $position;

    public $rules = [
        'displayName' => 'required',
        'status_id' => 'required'
    ];

    public $messages = [
        'displayName.required' => 'Elnevezés kitöltése kötelező',
        'status_id.required' => 'Egy státuszt ki kell választani'
    ];

    public function set_column(int $column_id) {
        $this->column = Column::where('id',  $column_id)->first();

        $this->displayName = $this->column->displayName;
        $this->status_id =  $this->column->status->id;
        $this->position = $this->column->position;
    }

    public function delete_current_data() {
        $this->reset();
    }

    public function store() {
        $this->validate();

        $last_column = Column::orderBy('position', 'desc')->first();

        $column = new Column([
            'displayName' => $this->displayName,
            'status_id' => $this->status_id,
            'position' => $last_column?->position + 1 ?? 1
        ]);

        $column->save();

        $this->reset();
    }

    public function update() {
        $this->validate();

        DB::transaction(function () {
            $original_position = $this->column->position;
            $new_position = $this->position;

            if ($new_position > $original_position) {
                Column::where('position', '>', $original_position)
                    ->where('position', '<=', $new_position)
                    ->decrement('position');
            } elseif ($new_position < $original_position) {
                Column::where('position', '>=', $new_position)
                    ->where('position', '<', $original_position)
                    ->increment('position');
            }

            $this->column->displayName = $this->displayName;
            $this->column->status_id = $this->status_id;
            $this->column->position = $new_position;

            $this->column->save();
        });
    }

    public function delete() {
        $delete_result = $this->column->delete();

        if (!isset($delete_result))
            throw new Exception('Törölni kívánt oszlop nem található.');

        $columns = Column::where([['position', '>', $this->column->position]])->get();

        foreach ($columns as $column) {
            $column->position--;
            $column->save();
        }

        $this->reset();
    }
}
