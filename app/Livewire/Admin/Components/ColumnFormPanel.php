<?php

namespace App\Livewire\Admin\Components;

use App\Livewire\Forms\ColumnForm;
use Exception;
use App\Models\Column;
use Livewire\Component;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class ColumnFormPanel extends Component {
    /** @var Collection<int,Status> $statuses */
    public Collection $statuses;

    public ColumnForm $form;

    //on show get how many columns
    public int $columns_number;

    protected $listeners = ['show_update_column', 'show_store_column_field'];

    public function show_update_column($column_id) {
        $this->form->set_column($column_id);
    }

    public function show_store_column_field() {
        $this->form->delete_current_data();
    }

    public function mount() {
        $this->columns_number = count(Column::all());
    }

    public function store_column() {
        try {
            $this->form->store();

            $this->dispatch('refresh_authorization_mount');
            $this->dispatch('save_column_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('save_column_error', $err->getMessage());

            $this->dispatch('refresh_authorization_mount');
        }
    }

    public function delete_column() {
        try {
            $this->form->delete();

            $this->dispatch('delete_column_success');
        } catch (QueryException $err) {
            $err_message = $err->getMessage();

            if ($err->getCode() == 23000) {
                $this->addError('column_error', "Nem lehet törölni ezt az oszlopot, mert valószínűleg kapcsolódik más adatokhoz (pl. nem üres ).");

                return;
            }

            $this->addError('column_error', "Ismeretlen hiba történt: $err_message");
        } catch (Exception $err) {
            $this->addError('column_error', $err->getMessage());
        } finally {
            $this->dispatch('refresh_authorization_mount');
        }
    }

    public function update_column() {
        try {
            $this->form->update();

            $this->dispatch('refresh_authorization_mount');
            $this->dispatch('save_column_success');
        } catch (ValidationException $err) {
            throw $err;
        } catch (Exception $err) {
            $this->addError('column_error', $err->getMessage());

            $this->dispatch('refresh_authorization_mount');
        }
    }

    public function render() {
        return view('livewire.admin.components.column-form-panel');
    }
}
