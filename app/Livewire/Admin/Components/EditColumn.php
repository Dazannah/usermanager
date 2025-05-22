<?php

namespace App\Livewire\Admin\Components;

use Exception;
use App\Models\Column;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

class EditColumn extends Component {
    //base properties
    /** @var Collection<int,Status> $statuses */
    public Collection $statuses;

    //on show get how many columns
    public int $columns_number;

    // livewire view properties
    public Column $edit_column;
    public string $edit_column_display_name;
    public int $edit_column_status_id, $edit_column_position;

    protected $listeners = ['edit_column_id'];

    public function edit_column_id($edit_column_id) {
        $this->edit_column = Column::where('id',  $edit_column_id)->first();

        $this->columns_number = count(Column::all());

        $this->edit_column_display_name = $this->edit_column->displayName;
        $this->edit_column_status_id =  $this->edit_column->status->id;
        $this->edit_column_position = $this->edit_column->position;
    }

    public function delete_edit_column() {
        try {
            $delete_result = $this->edit_column->delete();

            if (!isset($delete_result))
                throw new Exception('Törölni kívánt oszlop nem található.');

            $columns = Column::where([['position', '>', $this->edit_column->position]])->get();

            foreach ($columns as $column) {
                $column->position--;
                $column->save();
            }

            $this->reset('edit_column_display_name', 'edit_column_status_id', 'edit_column_position');

            $this->dispatch('edit_columns_delete_success');
        } catch (QueryException $err) {
            $err_message = $err->getMessage();

            if ($err->getCode() == 23000) {
                $this->addError('save_edit_column_error', "Nem lehet törölni ezt az oszlopot, mert valószínűleg kapcsolódik más adatokhoz (pl. nem üres ).");

                return;
            }

            $this->addError('save_edit_column_error', "Ismeretlen hiba történt: $err_message");
        } catch (Exception $err) {
            $this->addError('save_edit_column_error', $err->getMessage());
        } finally {
            $this->dispatch('refresh_authorization_mount');
        }
    }

    public function save_edit_column() {
        try {
            $rules = [
                'edit_column_display_name' => 'required',
                'edit_column_status_id' => 'required',
                'edit_column_position' => 'required'
            ];

            $messages = [
                'edit_column_display_name.required' => 'Elnevezés kitöltése kötelező',
                'edit_column_status_id.required' => 'Egy státuszt ki kell választani',
                'edit_column_position.required' => 'Pozíció megadása kötelező'
            ];

            $this->validate($rules, $messages);

            $this->change_columns_position();

            $this->edit_column->displayName = $this->edit_column_display_name;
            $this->edit_column->status_id = $this->edit_column_status_id;
            $this->edit_column->position = $this->edit_column_position;

            $this->edit_column->save();

            $this->dispatch('refresh_authorization_mount');
            $this->dispatch('edit_columns_save_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('save_edit_column_error', $err->getMessage());

            $this->dispatch('refresh_authorization_mount');
        }
    }

    public function change_columns_position() {
        try {
            $columns = Column::all();

            $original_position = $this->edit_column->position;
            $new_position = $this->edit_column_position;

            foreach ($columns as $column) {
                if ($column->id == $this->edit_column->id)
                    continue;

                if ($new_position > $original_position && $column->position <= $new_position && $original_position <= $column->position) {
                    $column->position--;
                    $column->save();
                }

                if ($new_position < $original_position && $column->position >= $new_position && $original_position >= $column->position) {

                    $column->position++;
                    $column->save();
                }
            };
        } catch (Exception $err) {
            $this->addError('save_edit_column_error', $err->getMessage());
        }
    }

    public function render() {
        return view('livewire.admin.components.edit-column');
    }
}
