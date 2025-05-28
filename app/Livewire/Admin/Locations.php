<?php

namespace App\Livewire\Admin;

use App\Models\Status;
use Livewire\Component;
use App\Models\Location;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Collection;

class Locations extends Component {
    use WithPagination;

    /** @var Collection<int,Status> */
    public Collection $statuses;

    //filter properties
    #[Url(as: 'displayName')]
    public string|null $search_location_displayName;
    #[Url(as: 'note')]
    public string|null $search_location_note;
    #[Url(as: 'status_id')]
    public int|null $search_location_status_id;

    public $listeners = ['refresh_locations_mount', 'location_filter_reset'];

    public function refresh_locations_mount() {
        $this->mount();
    }

    public function location_filter_reset() {
        $this->reset('search_location_displayName', 'search_location_status_id', 'search_location_note');
        $this->resetPage();
        $this->dispatch('refresh_locations_mount');
    }

    public function mount() {
        $this->statuses = Status::all();

        $this->filter_locations();
    }

    //search
    public function filter_locations() {
        return Location::when(
            isset($this->search_location_displayName) && !empty($this->search_location_displayName),
            function ($query) {
                return $query->where('displayName', 'REGEXP', $this->search_location_displayName);
            }
        )->when(
            isset($this->search_location_status_id),
            function ($query) {
                return $query->where('status_id', '=', $this->search_location_status_id);
            }
        )->when(
            isset($this->search_location_note) && !empty($this->search_location_note),
            function ($query) {
                return $query->where('note', 'REGEXP', $this->search_location_note);
            }
        )->paginate(15);
    }

    public function render() {
        return view('livewire.admin.locations', [
            'locations' => $this->filter_locations()
        ])->layout('layouts.admin');
    }
}
