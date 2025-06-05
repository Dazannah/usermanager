<?php

namespace App\Livewire\Forms;

use Exception;
use Livewire\Form;
use App\Models\AuthItem;
use Livewire\Attributes\Validate;

class AuthorizationForm extends Form {
    // livewire view properties
    public AuthItem|null $authItem;

    public string|null $displayName;
    public int $status_id = 1;
    public int|null $column_id, $position;
    public bool $is_ldap = false;

    public $rules = [
        'displayName' => 'required',
        'column_id' => 'required',
        'status_id' => 'required'
    ];
    public $messages = [
        'displayName.required' => 'Elnevezés kitöltése kötelező',
        'column_id.required' => 'Egy oszlopot ki kell választani',
        'status_id.required' => 'Egy státuszt ki kell választani'
    ];

    public function set_authItem($authItem_id) {
        $this->authItem = AuthItem::where('id',  $authItem_id)->first();

        $this->displayName = $this->authItem->displayName;
        $this->column_id =  $this->authItem->column->id;
        $this->status_id = $this->authItem->status->id;
        $this->position = $this->authItem->position;
        $this->is_ldap = $this->authItem->is_ldap;
    }

    public function delete_current_data() {
        $this->reset();
    }

    public function store() {
        $this->validate();

        $last_authItem = AuthItem::where('column_id', '=', $this->column_id)->orderBy('position', 'desc')->first();

        $authItem = new AuthItem([
            'displayName' => $this->displayName,
            'column_id' => $this->column_id,
            'status_id' => $this->status_id,
            'position' => $last_authItem?->position + 1 ?? 1,
            'is_ldap' => $this->is_ldap
        ]);

        $authItem->save();

        $this->reset();
    }

    public function update() {
        $this->validate();

        //if column id change
        if ($this->authItem->column->id !== $this->column_id)
            $this->set_new_positions();

        $this->authItem->displayName = $this->displayName;
        $this->authItem->column_id = $this->column_id;
        $this->authItem->status_id = $this->status_id;
        $this->authItem->is_ldap = $this->is_ldap;

        $this->authItem->save();
    }

    public function set_new_positions() {
        try {
            if ($this->authItem->column_id != $this->column_id) {
                $new_column_last_item = AuthItem::where('column_id', $this->column_id)->orderBy('position', 'desc')->first();
                $this->authItem->position = $new_column_last_item?->position + 1 ?? 1;
            }

            $original_column_items = AuthItem::where('column_id', $this->authItem->column->id)->get();

            foreach ($original_column_items as $original_column_item) {
                if ($original_column_item->id === $this->authItem->id) {
                    continue;
                }

                if ($original_column_item->position > $this->column_id) {
                    $original_column_item->position--;
                    $original_column_item->save();
                }
            }
        } catch (Exception $err) {
            $this->addError('save_edit_authorization_error', $err->getMessage());
        }
    }
    public function render() {
        return view('livewire.admin.components.authorization-form-panel');
    }
}
