<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Location;
use App\Models\Status;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Url;

class Locations extends Component {
    /** @var Collection<int,Location> $locations */
    public Collection $locations;

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
        $this->dispatch('refresh_locations_mount');
    }

    public function mount() {
        $this->filter_locations();
        $this->statuses = Status::all();
    }

    //search
    public function filter_locations() {
        $this->locations = Location::when(
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
        )->get();
    }

    public function render() {
        return view('livewire.admin.locations')->layout('layouts.admin');
    }
}
