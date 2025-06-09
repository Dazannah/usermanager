<?php

namespace App\Livewire\Setup;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class LocalAccountSessions extends Component {
    use WithPagination;

    #[Url]
    public string|null $name;
    #[Url]
    public string|null $username;
    // public string|null $id;

    public $listeners = ['sessions_filter_reset', 'delete_session'];

    public function sessions_filter_reset() {
        $this->reset('name', 'username');
        $this->resetPage();
    }

    public function delete_session($session_id) {
        DB::table(config('session.table'))->where('id', $session_id)->delete();
    }

    public function filter_sessions() {
        $sessions = DB::table(config('session.table'))
            ->select(['users.name', 'users.username', 'sessions.id'])
            ->whereNotNull('user_id')
            ->when(
                isset($this->name) && !empty($this->name),
                function ($query) {
                    return $query->where('users.name', 'REGEXP', $this->name);
                }
            )->when(
                isset($this->username) && !empty($this->username),
                function ($query) {
                    return $query->where('users.username', 'REGEXP', $this->username);
                }
            )
            ->join('users', config('session.table') . '.user_id', '=', 'users.id')
            ->paginate(10);
        return $sessions;
    }

    public function render() {
        return view('livewire.setup.local-account-sessions', [
            'sessions' => $this->filter_sessions()
        ])->layout('layouts.admin');
    }
}
