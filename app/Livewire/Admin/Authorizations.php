<?php

namespace App\Livewire\Admin;

use App\Models\AuthItem;
use App\Models\Column;
use App\Models\Status;
use App\Models\SubAuthItem;
use Livewire\Component;
use Livewire\Attributes\On;

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
        $this->columns = Column::all();
        $this->authorizations = AuthItem::all();
        $this->sub_authorization = SubAuthItem::all();
    }

    public function toggle_add_column_field() {
        $this->show_add_column_field = !$this->show_add_column_field;
    }

    public function save_column() {
        $rules = [
            'column_display_name' => 'required',
            'column_status_id' => 'required'
        ];

        $messages = [
            'column_display_name.required' => 'Elnevezés kitöltése kötelező',
            'column_status_id.required' => 'Egy státuszt ki kell választani'
        ];

        $this->validate($rules, $messages);

        $column = new Column([
            'displayName' => $this->column_display_name,
            'status_id' => $this->column_status_id,
            'position' => $this->column_position
        ]);

        $column->save();

        $this->reset('column_display_name', 'column_status_id');
        $this->columns = Column::all();

        $this->dispatch('columns-save-success');
    }

    public function save_authorization() {
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

        $authItem = new AuthItem([
            'displayName' => $this->authorization_display_name,
            'column_id' => $this->authorization_column_id,
            'status_id' => $this->authorization_status_id,
            'position' => $this->authorization_position
        ]);

        $authItem->save();

        $this->reset('authorization_display_name', 'authorization_column_id', 'authorization_status_id');
        $this->authorizations = AuthItem::all();

        $this->dispatch('authorization-save-success');
    }

    public function save_sub_authorization() {
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

        $sub_auth_item = new SubAuthItem([
            'displayName' => $this->sub_auth_item_display_name,
            'authItem_id' => $this->sub_auth_item_authItem_Id,
            'status_id' => $this->sub_auth_item_status_id,
            'position' => $this->sub_auth_item_position
        ]);

        $sub_auth_item->save();

        $this->reset('sub_auth_item_display_name', 'sub_auth_item_authItem_Id', 'sub_auth_item_status_id');
        $this->authorizations = AuthItem::all();

        $this->dispatch('sub-authitem-save-success');
    }

    public function render() {
        return view('livewire.admin.authorizations')->layout('layouts.admin');
    }
}
