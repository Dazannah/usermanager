<?php

namespace App\Livewire\Forms;

use Exception;
use Livewire\Form;
use App\Models\AuthItem;
use Illuminate\Support\Facades\DB;

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

        DB::transaction(function () {
            $original_position = $this->authItem->position;
            $new_position = $this->position;

            if ($new_position > $original_position) {
                AuthItem::where('position', '>', $original_position)
                    ->where('position', '<=', $new_position)
                    ->decrement('position');
            } elseif ($new_position < $original_position) {
                AuthItem::where('position', '>=', $new_position)
                    ->where('position', '<', $original_position)
                    ->increment('position');
            }

            $this->authItem->displayName = $this->displayName;
            $this->authItem->column_id = $this->column_id;
            $this->authItem->status_id = $this->status_id;
            $this->authItem->is_ldap = $this->is_ldap;

            $this->authItem->save();
        });
    }

    public function delete() {
        DB::transaction(function () {
            $delete_result = $this->authItem->delete();

            if (!isset($delete_result))
                throw new Exception('Törölni kívánt jogosultság nem található.');

            AuthItem::where('position', '>', $this->authItem->position)
                ->where('column_id', $this->authItem->column_id)
                ->decrement('position');
        });

        $this->reset();
    }

    public function render() {
        return view('livewire.admin.components.authorization-form-panel');
    }
}
