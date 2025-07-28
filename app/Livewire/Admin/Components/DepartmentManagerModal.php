<?php

namespace App\Livewire\Admin\Components;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DepartmentManager;
use Livewire\WithoutUrlPagination;
use Illuminate\Database\Eloquent\Collection;

class DepartmentManagerModal extends Component {
    use WithPagination, WithoutUrlPagination;

    /** @var Collection<int,Status> $statuses */
    public Collection $statuses;

    public string $search_department_manager_displayName;
    public string $search_department_manager_registration_number;
    public string $search_department_manager_note;

    public function getPageName() {
        return 'manager_page';
    }

    public  $listeners = ['filter_department_managers', 'department_manager_filter_reset', 'refresh_department_managers_mount'];

    public function mount() {
    }

    public function refresh_department_managers_mount() {
        $this->mount();
    }

    public function department_manager_filter_reset() {
        $this->reset('search_department_manager_displayName', 'search_department_manager_registration_number', 'search_department_manager_note');
        $this->resetPage();
        $this->dispatch('refresh_department_managers_mount');
    }

    public function filter_department_managers() {
        return DepartmentManager::when(
            isset($this->search_department_manager_displayName) && !empty($this->search_department_manager_displayName),
            function ($query) {
                return $query->whereHas('worker', function ($inside_query) {
                    $inside_query->where('name', 'LIKE', "%$this->search_department_manager_displayName%");
                });
            }
        )->when(
            isset($this->search_department_manager_registration_number) && !empty($this->search_department_manager_registration_number),
            function ($query) {
                return $query->whereHas('worker', function ($inside_query) {
                    $inside_query->where('registration_number', 'LIKE', "%$this->search_department_manager_registration_number%");
                });
            }
        )->when(
            isset($this->search_department_manager_note) && !empty($this->search_department_manager_note),
            function ($query) {
                return $query->where('note', 'LIKE', "%$this->search_department_manager_note%");
            }
        )->paginate(10);
    }

    public function render() {
        return view('livewire.admin.components.department-manager-modal', [
            'department_managers' => $this->filter_department_managers()
        ]);
    }
}
