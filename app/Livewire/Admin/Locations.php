<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Location;
use App\Models\Status;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class Locations extends Component {
    /** @var Collection<int,Location> $locations */
    public Collection $locations;

    /** @var Collection<int,Status> */
    public Collection $statuses;

    //filter properties
    public $search_location_displayName, $search_location_status, $search_location_note;

    public $listeners = ['refresh_locations_mount', 'location_filter_reset'];

    public function refresh_locations_mount() {
        $this->mount();
    }

    public function location_filter_reset() {
        $this->reset('search_location_displayName', 'search_location_status', 'search_location_note');
    }

    public function mount() {
        $this->locations = Location::all();
        $this->statuses = Status::all();
    }

    //search
    public function filter_locations() {
    }

    public function render() {
        return view('livewire.admin.locations')->layout('layouts.admin');
    }
}
