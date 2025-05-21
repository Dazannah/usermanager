<?php

namespace App\Livewire\Admin\Components;

use Exception;
use Livewire\Component;
use App\Models\AuthItem;
use App\Models\Column;
use Illuminate\Validation\ValidationException;

class CreateAuthorization extends Component {
    public $statuses, $columns;

    // new authorization
    public $authorization_display_name, $authorization_column_id;
    public $authorization_status_id = 1;
    public $authorization_position;
    public $authorization_is_ldap = false;

    protected $listeners = ['update_create_authorization'];

    public function update_create_authorization() {
        $this->columns = Column::all();
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
                'position' => $auth_item?->position + 1 ?? 1,
                'is_ldap' => $this->authorization_is_ldap
            ]);

            $authItem->save();

            $this->reset('authorization_display_name', 'authorization_column_id', 'authorization_status_id');
            $this->dispatch('refresh_authorization_mount');
            $this->dispatch('authorization_save_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('save_authorization_error', $err->getMessage());

            $this->dispatch('refresh_authorization_mount');
        }
    }

    public function render() {
        return view('livewire.admin.components.create-authorization');
    }
}
