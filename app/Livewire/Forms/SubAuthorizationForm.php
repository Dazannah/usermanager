<?php

namespace App\Livewire\Forms;

use Exception;
use Livewire\Form;
use App\Models\SubAuthItem;
use Illuminate\Support\Facades\DB;

class SubAuthorizationForm extends Form {
    public SubAuthItem|null $subAuthItem;

    //livewire view properties
    public int|null $id;
    public string|null $displayName;
    public int|null $authItem_id;
    public int $status_id = 1;
    public int|null $position;
    public int|null $subAuthItems_number = 0;

    public $rules = [
        'displayName' => 'required',
        'authItem_id' => 'required',
        'status_id' => 'required',
    ];

    public $messages = [
        'displayName.required' => 'Elnevezés kitöltése kötelező',
        'authItem_id.required' => 'Egy jogosultságot ki kell választani',
        'status_id.required' => 'Egy státuszt ki kell választani',
    ];

    public function set_subAuthItem($subAuthItem_id) {
        $this->subAuthItem = SubAuthItem::where('id', $subAuthItem_id)->first();
        $this->subAuthItems_number = SubAuthItem::where('authItem_id', $this->subAuthItem->authItem_id)->get()->count();

        $this->id = $this->subAuthItem->id;
        $this->displayName = $this->subAuthItem->displayName;
        $this->authItem_id = $this->subAuthItem->authItem_id;
        $this->status_id = $this->subAuthItem->status_id;
        $this->position = $this->subAuthItem->position;
    }

    public function delete_current_data() {
        $this->reset();
    }

    public function store() {
        $this->validate();

        $last_subAuthItem = SubAuthItem::where('authItem_id', '=', $this->authItem_id)->orderBy('position', 'desc')->first();

        $sub_auth_item = new SubAuthItem([
            'displayName' => $this->displayName,
            'authItem_id' => $this->authItem_id,
            'status_id' => $this->status_id,
            'position' => $last_subAuthItem?->position + 1 ?? 1
        ]);

        $sub_auth_item->save();

        $this->reset();
    }

    public function update() {
        $this->validate();
        $this->validate(
            ['position' => "required|numeric|min:1|max:$this->subAuthItems_number"],
            [
                'position.required' => 'A pozíció megadása kötelező.',
                'position.numeric' => 'A pozíciónak számnak kell lennie.',
                'position.min' => "A pozíció nem lehet kisebb, mint 1",
                'position.max' => "A pozíció nem lehet nagyobb, mint ($this->subAuthItems_number)."
            ]
        );

        if ($this->subAuthItem->authItem_id != $this->authItem_id)
            $this->set_position_in_new_authItem();

        DB::transaction(function () {
            $original_position = $this->subAuthItem->position;
            $new_position = $this->position;

            if ($new_position > $original_position) {
                SubAuthItem::where('position', '>', $original_position)
                    ->where('position', '<=', $new_position)
                    ->decrement('position');
            } elseif ($new_position < $original_position) {
                SubAuthItem::where('position', '>=', $new_position)
                    ->where('position', '<', $original_position)
                    ->increment('position');
            }

            $this->subAuthItem->displayName = $this->displayName;
            $this->subAuthItem->authItem_id = $this->authItem_id;
            $this->subAuthItem->status_id = $this->status_id;
            $this->subAuthItem->position = $this->position;

            $this->subAuthItem->save();
        });

        $this->set_subAuthItem($this->subAuthItem->id);
    }

    public function delete() {
        $delete_result = $this->subAuthItem->delete();

        if (!isset($delete_result))
            throw new Exception('Törölni kívánt aljogosultság nem található.');

        $sub_authItems = SubAuthItem::where('authItem_id', $this->subAuthItem->authItem_id)->get();

        /** @var SubAuthItem $sub_authItem */
        foreach ($sub_authItems as $sub_authItem) {
            if ($sub_authItem->position >= $this->subAuthItem->position) {
                $sub_authItem->position--;
                $sub_authItem->save();
            }
        }

        $this->reset();
    }

    public function set_position_in_new_authItem() {
        $new_authItem_last_item = SubAuthItem::where('authItem_id', $this->authItem_id)->orderBy('position', 'desc')->first();
        $this->subAuthItem->position = $new_authItem_last_item?->position + 1 ?? 1;
    }
}
