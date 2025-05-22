<?php

namespace App\Livewire\Admin;

use App\Models\AuthItem;
use App\Models\Column;
use App\Models\Status;
use App\Models\SubAuthItem;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Authorizations extends Component {
    /** @var Collection<int,Status> */
    public Collection $statuses;

    /** @var Collection<int,Column> */
    public Collection $columns;

    /** @var Collection<int,AuthItem> */
    public Collection $authorizations;

    /** @var Collection<int,SubAuthItem> */
    public Collection $sub_authorization;

    protected $listeners = ['refresh_authorization_mount'];

    public function mount() {
        $this->statuses = Status::all();
        $this->columns = Column::all_sorted_auth_items_by_position();
        $this->authorizations = AuthItem::all();
        $this->sub_authorization = SubAuthItem::all();
    }

    public function refresh_authorization_mount() {
        $this->mount();
        $this->dispatch('update_create_authorization');
        $this->dispatch('update_create_sub_authorization');
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

    public function render() {
        return view('livewire.admin.authorizations')->layout('layouts.admin');
    }
}
