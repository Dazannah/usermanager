<?php

namespace App\Livewire\Admin\Components;

use Exception;
use App\Models\Column;
use Livewire\Component;
use App\Models\AuthItem;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class EditAuthorization extends Component {
    public $statuses, $columns;

    //edit properties
    public $edit_authItem, $edit_authorization_display_name, $edit_authorization_column_id, $edit_authorization_status_id, $edit_authorization_original_position;

    protected $listeners = ['edit_authorization_id'];

    public function edit_authorization_id($edit_authorization_id) {
        $this->edit_authItem = AuthItem::where('id',  $edit_authorization_id)->first();

        $this->columns = Column::all_sorted_auth_items_by_position();

        $this->edit_authorization_display_name = $this->edit_authItem->displayName;
        $this->edit_authorization_column_id =  $this->edit_authItem->column->id;
        $this->edit_authorization_status_id = $this->edit_authItem->status->id;
        $this->edit_authorization_original_position = $this->edit_authItem->position;
    }

    public function delete_edit_authorization() {
        try {
            $delete_result = $this->edit_authItem->delete();

            if (!isset($delete_result))
                throw new Exception('Törölni kívánt oszlop nem található.');

            $authItems = AuthItem::where([['position', '>', $this->edit_authItem->position]])->get();

            foreach ($authItems as $authItem) {
                $authItem->position--;
                $authItem->save();
            }

            $this->reset('edit_authorization_display_name', 'edit_authorization_column_id', 'edit_authorization_status_id');

            $this->dispatch('edit_authorization_delete_success');
        } catch (QueryException $err) {
            $err_message = $err->getMessage();

            if ($err->getCode() == 23000) {
                $this->addError('save_edit_authorization_error', "Nem lehet törölni ezt a jogosultságot, mert valószínűleg kapcsolódik más adatokhoz (pl. van aljogosultsága).");

                return;
            }

            $this->addError('save_edit_authorization_error', "Ismeretlen hiba történt: $err_message");
        } catch (Exception $err) {
            $this->addError('save_edit_authorization_error', $err->getMessage());
        } finally {
            $this->dispatch('refresh_authorization_mount');
        }
    }

    public function save_edit_authorization() {
        try {
            $rules = [
                'edit_authorization_display_name' => 'required',
                'edit_authorization_column_id' => 'required',
                'edit_authorization_status_id' => 'required'
            ];

            $messages = [
                'edit_authorization_display_name.required' => 'Elnevezés kitöltése kötelező',
                'edit_authorization_column_id.required' => 'Egy oszlop kiválasztása kötelező.',
                'edit_authorization_status_id.required' => 'Pozíció megadása kötelező'
            ];

            $this->validate($rules, $messages);

            //if column id change
            if ($this->edit_authItem->column->id !== $this->edit_authorization_column_id)
                $this->set_new_positions();

            $this->edit_authItem->displayName = $this->edit_authorization_display_name;
            $this->edit_authItem->column_id = $this->edit_authorization_column_id;
            $this->edit_authItem->status_id = $this->edit_authorization_status_id;

            $this->edit_authItem->save();

            // $this->reset('edit_column_display_name', 'edit_column_status_id', 'edit_column_position');
            $this->dispatch('refresh_authorization_mount');
            $this->dispatch('edit_authorization_save_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('save_edit_authorization_error', $err->getMessage());

            $this->dispatch('refresh_authorization_mount');
        }
    }

    public function set_new_positions() {
        try {
            if ($this->edit_authItem->column_id != $this->edit_authorization_column_id) {
                $new_column_last_item = AuthItem::where('column_id', $this->edit_authorization_column_id)->orderBy('position', 'desc')->first();
                $this->edit_authItem->position = $new_column_last_item?->position + 1 ?? 1;
            }

            $original_column_items = AuthItem::where('column_id', $this->edit_authItem->column->id)->get();

            foreach ($original_column_items as $original_column_item) {
                if ($original_column_item->id === $this->edit_authItem->id) {
                    continue;
                }

                if ($original_column_item->position > $this->edit_authorization_original_position) {
                    $original_column_item->position--;
                    $original_column_item->save();
                }
            }
        } catch (Exception $err) {
            $this->addError('save_edit_authorization_error', $err->getMessage());
        }
    }

    public function render() {
        return view('livewire.admin.components.edit-authorization');
    }
}
