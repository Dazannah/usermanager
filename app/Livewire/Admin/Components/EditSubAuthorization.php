<?php

namespace App\Livewire\Admin\Components;

use Exception;
use App\Models\Status;
use Livewire\Component;
use App\Models\AuthItem;
use App\Models\SubAuthItem;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException as DatabaseQueryException;

class EditSubAuthorization extends Component {
    /** @var Collection<int,Status> $statuses */
    public Collection $statuses;

    /** @var Collection<int,AuthItem> $authorizations */
    public Collection $authorizations;

    public SubAuthItem $edit_subAuthItem;

    //livewire view properties
    public $edit_sub_auth_item_display_name, $edit_sub_auth_item_authItem_Id, $edit_sub_auth_item_status_id, $edit_sub_auth_item_position, $edit_subAuthItem_number;

    protected $listeners = ['edit_sub_authorization_id'];

    public function edit_sub_authorization_id($id) {
        $this->edit_subAuthItem = SubAuthItem::where('id', $id)->first();
        $asd = SubAuthItem::where('authItem_id', $this->edit_subAuthItem->authItem_id)->get();
        $this->edit_subAuthItem_number = count($asd);

        $this->edit_sub_auth_item_display_name = $this->edit_subAuthItem->displayName;
        $this->edit_sub_auth_item_authItem_Id = $this->edit_subAuthItem->authItem_id;
        $this->edit_sub_auth_item_status_id = $this->edit_subAuthItem->status_id;
        $this->edit_sub_auth_item_position = $this->edit_subAuthItem->position;
    }

    public function save_edit_sub_authorization() {
        try {
            $rules = [
                'edit_sub_auth_item_display_name' => 'required',
                'edit_sub_auth_item_authItem_Id' => 'required',
                'edit_sub_auth_item_status_id' => 'required',
                'edit_sub_auth_item_position' => 'required',
            ];

            $messages = [
                'sub_auth_item_display_name.required' => 'Elnevezés kitöltése kötelező.',
                'sub_auth_item_authItem_Id.required' => 'Egy jogosultságot ki kell választani.',
                'sub_auth_item_status_id.required' => 'Egy státuszt ki kell választani.',
                'edit_sub_auth_item_position.required' => 'Pozíció megadása kötelező.',
            ];

            $this->validate($rules, $messages);

            if ($this->edit_subAuthItem->authItem_id != $this->edit_sub_auth_item_authItem_Id)
                $this->set_position_in_new_authItem();

            if ($this->edit_subAuthItem->position != $this->edit_sub_auth_item_position)
                $this->change_sub_authItems_position();

            $this->edit_subAuthItem->displayName = $this->edit_sub_auth_item_display_name;
            $this->edit_subAuthItem->authItem_id = $this->edit_sub_auth_item_authItem_Id;
            $this->edit_subAuthItem->status_id = $this->edit_sub_auth_item_status_id;
            $this->edit_subAuthItem->position = $this->edit_sub_auth_item_position;

            $this->edit_subAuthItem->save();
            $this->dispatch('save_edit_sub_authorization_success');
            $this->dispatch('edit_sub_authorization_id', $this->edit_subAuthItem->id);
        } catch (Exception $err) {
            $this->addError('save_edit_sub_authorization_error', $err->getMessage());
        } finally {
            $this->dispatch('refresh_authorization_mount');
        }
    }

    public function change_sub_authItems_position() {
        try {
            $subAuthItems = SubAuthItem::where('authItem_id', $this->edit_subAuthItem->authItem_id)->get();

            $original_position = $this->edit_subAuthItem->position;
            $new_position = $this->edit_sub_auth_item_position;

            foreach ($subAuthItems as $subAuthItem) {
                if ($subAuthItem->id == $this->edit_subAuthItem->id)
                    continue;

                if ($new_position > $original_position && $subAuthItem->position <= $new_position && $original_position <= $subAuthItem->position) {
                    $subAuthItem->position--;
                    $subAuthItem->save();
                }

                if ($new_position < $original_position && $subAuthItem->position >= $new_position && $original_position >= $subAuthItem->position) {

                    $subAuthItem->position++;
                    $subAuthItem->save();
                }
            };
        } catch (Exception $err) {
            $this->addError('save_edit_sub_authorization_error', $err->getMessage());
        }
    }

    public function set_position_in_new_authItem() {
        try {
            if ($this->edit_subAuthItem->authItem_id != $this->edit_sub_auth_item_authItem_Id) {
                $new_authItem_last_item = SubAuthItem::where('authItem_id', $this->edit_sub_auth_item_authItem_Id)->orderBy('position', 'desc')->first();
                $this->edit_subAuthItem->position = $new_authItem_last_item?->position + 1 ?? 1;
            }

            $original_authItem_items = SubAuthItem::where('authItem_id', $this->edit_subAuthItem->authItem_id)->get();

            foreach ($original_authItem_items as $original_authItem_item) {
                if ($original_authItem_item->id === $this->edit_subAuthItem->id) {
                    continue;
                }

                if ($original_authItem_item->position > $this->edit_subAuthItem->position) {
                    $original_authItem_item->position--;
                    $original_authItem_item->save();
                }
            }
        } catch (Exception $err) {
            $this->addError('save_edit_sub_authorization_error', $err->getMessage());
        }
    }

    public function delete_edit_sub_authorization() {
        try {
            $delete_result = $this->edit_subAuthItem->delete();

            if (!isset($delete_result))
                throw new Exception('Törölni kívánt aljogosultság nem található.');

            $sub_authItems = SubAuthItem::where('authItem_id', $this->edit_subAuthItem->authItem_id)->get();

            /** @var SubAuthItem $sub_authItem */
            foreach ($sub_authItems as $sub_authItem) {
                if ($sub_authItem->position >= $this->edit_subAuthItem->position) {
                    $sub_authItem->position--;
                    $sub_authItem->save();
                }
            }

            $this->reset('edit_sub_auth_item_display_name', 'edit_sub_auth_item_authItem_Id', 'edit_sub_auth_item_status_id', 'edit_sub_auth_item_position', 'edit_subAuthItem_number');

            $this->dispatch('edit_sub_authorization_delete_success');
        } catch (QueryException $err) {
            $err_message = $err->getMessage();

            if ($err->getCode() == 23000) {
                $this->addError('save_edit_authorization_error', "Nem lehet törölni ezt az aljogosultságot, mert valószínűleg kapcsolódik más adatokhoz.");

                return;
            }

            $this->addError('save_edit_authorization_error', "Ismeretlen hiba történt: $err_message");
        } catch (Exception $err) {
            $this->addError('save_edit_authorization_error', $err->getMessage());
        } finally {
            $this->dispatch('refresh_authorization_mount');
        }
    }

    public function render() {
        return view('livewire.admin.components.edit-sub-authorization');
    }
}
