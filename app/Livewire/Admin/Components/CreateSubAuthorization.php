<?php

namespace App\Livewire\Admin\Components;

use App\Models\AuthItem;
use Exception;
use Livewire\Component;
use App\Models\SubAuthItem;
use Illuminate\Validation\ValidationException;

class CreateSubAuthorization extends Component {
    public $statuses, $authorizations;

    protected $listeners = ['update_create_sub_authorization'];

    public function update_create_sub_authorization() {
        $this->authorizations = AuthItem::all();
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
            $this->dispatch('refresh_authorization_mount');
            $this->dispatch('sub_authitem_save_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('save_sub_authorization_error', $err->getMessage());

            $this->dispatch('refresh_authorization_mount');
        }
    }

    public function render() {
        return view('livewire.admin.components.create-sub-authorization');
    }
}
