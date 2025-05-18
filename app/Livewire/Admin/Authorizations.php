<?php

namespace App\Livewire\Admin;

use App\Models\AuthItem;
use App\Models\Column;
use App\Models\Status;
use App\Models\SubAuthItem;
use Exception;
use Livewire\Component;

class Authorizations extends Component {
    // trackers for show add divs
    public $show_add_column_field, $show_add_authorization_field, $show_add_sub_authorization_field;

    // datas
    public $statuses, $columns, $authorizations, $sub_authorization;

    //create properties
    // new column
    public $column_display_name;
    public $column_status_id = 1;
    public $column_position = 0;

    // new authorization
    public $authorization_display_name, $authorization_column_id;
    public $authorization_status_id = 1;
    public $authorization_position = 0;

    // new sub_auth_item
    public $sub_auth_item_display_name, $sub_auth_item_authItem_Id;
    public $sub_auth_item_status_id = 1;
    public $sub_auth_item_position = 0;

    public function mount() {
        $this->show_add_column_field = false;
        $this->show_add_authorization_field = false;
        $this->show_add_sub_authorization_field = false;

        $this->statuses = Status::all();
        $this->columns = Column::all_sorted_auth_items_by_position();
        $this->authorizations = AuthItem::all();
        $this->sub_authorization = SubAuthItem::all();
    }

    public function toggle_add_column_field() {
        $this->show_add_column_field = !$this->show_add_column_field;
    }

    public function save_order($item, $new_position) {
        try {
            $new_position++;

            $position_auth_item = AuthItem::where('id', $item)->first();
            $original_position = $position_auth_item->position;

            $column_auth_items = AuthItem::where('column_id', $position_auth_item->column_id)->orderBy('position', 'asc')->get();

            foreach ($column_auth_items as $auth_item) {
                if ($auth_item->id == $item)
                    continue;

                if ($new_position > $original_position && $auth_item->position <= $new_position && $original_position <= $auth_item->position) {
                    $auth_item->position -= 1;
                    $auth_item->save();
                }

                if ($new_position < $original_position && $auth_item->position >= $new_position && $original_position >= $auth_item->position) {

                    $auth_item->position += 1;
                    $auth_item->save();
                }
            };

            $position_auth_item->position = $new_position;
            $position_auth_item->save();

            $this->columns = Column::all_sorted_auth_items_by_position();
        } catch (Exception $err) {
            $this->addError('error', $err->getMessage());

            $this->mount();
        }
    }

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
            $this->mount();
            $this->dispatch('columns_save_success');
        } catch (Exception $err) {
            $this->addError('save_column_error', $err->getMessage());

            $this->mount();
        }
    }

    public function save_authorization() {
        try {
            $rules = [
                'authorization_display_name' => 'required',
                'authorization_column_id' => 'required',
                'authorization_status_id' => 'required'
            ];

            $messages = [
                'authorization_display_name.required' => 'Elnevezés kitöltése kötelező',
                'authorization_column_id.required' => 'Egy oszlopot ki kell választani',
                'authorization_status_id.required' => 'Egy státuszt ki kell választani'
            ];

            $this->validate($rules, $messages);


            $auth_item = AuthItem::where('column_id', '=', $this->authorization_column_id)->orderBy('position', 'desc')->first();

            $authItem = new AuthItem([
                'displayName' => $this->authorization_display_name,
                'column_id' => $this->authorization_column_id,
                'status_id' => $this->authorization_status_id,
                'position' => $auth_item?->position + 1 ?? 1
            ]);

            $authItem->save();

            $this->reset('authorization_display_name', 'authorization_column_id', 'authorization_status_id');
            $this->mount();
            $this->dispatch('authorization_save_success');
        } catch (Exception $err) {
            $this->addError('save_authorization_error', $err->getMessage());

            $this->mount();
        }
    }

    public function save_sub_authorization() {
        try {
            $rules = [
                'sub_auth_item_display_name' => 'required',
                'sub_auth_item_authItem_Id' => 'required',
                'sub_auth_item_status_id' => 'required',
            ];

            $messages = [
                'sub_auth_item_display_name.required' => 'Elnevezés kitöltése kötelező',
                'sub_auth_item_authItem_Id.required' => 'Egy jogosultságot ki kell választani',
                'sub_auth_item_status_id.required' => 'Egy státuszt ki kell választani',
            ];

            $this->validate($rules, $messages);

            $auth_item = SubAuthItem::where('authItem_id', '=', $this->sub_auth_item_authItem_Id)->orderBy('position', 'desc')->first();

            $sub_auth_item = new SubAuthItem([
                'displayName' => $this->sub_auth_item_display_name,
                'authItem_id' => $this->sub_auth_item_authItem_Id,
                'status_id' => $this->sub_auth_item_status_id,
                'position' => $auth_item?->position + 1 ?? 1
            ]);

            $sub_auth_item->save();

            $this->reset('sub_auth_item_display_name', 'sub_auth_item_authItem_Id', 'sub_auth_item_status_id');
            $this->mount();
            $this->dispatch('sub_authitem_save_success');
        } catch (Exception $err) {
            $this->addError('save_sub_authorization_error', $err->getMessage());

            $this->mount();
        }
    }

    public function render() {
        return view('livewire.admin.authorizations')->layout('layouts.admin');
    }
}
