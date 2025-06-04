<?php

namespace App\Livewire\Admin;

use stdClass;
use App\Models\User;
use App\Models\Status;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\AccountAuthorizationLevel;
use App\Services\AuthorizationLevelService;
use Illuminate\Database\Eloquent\Collection;

class LocalAccounts extends Component {
    use WithPagination;

    /** @var Collection<int,Status> $statuses*/
    public Collection $statuses;

    /** @var Collection<int,Status> $accountAuthorizationLevels*/
    public Collection $accountAuthorizationLevels;

    //filter properties
    #[Url(as: 'name')]
    public string|null $search_user_name;
    #[Url(as: 'username')]
    public string|null $search_user_username;
    #[Url(as: 'email')]
    public string|null $search_user_email;
    #[Url(as: 'authorizationlevel')]
    public string|null $search_user_authorization_level;
    #[Url(as: 'statusid')]
    public int|null $search_user_status_id;

    public $select_user_type;

    public $listeners = ['refresh_local_accounts_mount', 'local_accounts_filter_reset'];

    public function refresh_local_accounts_mount() {
        $this->mount();
    }

    public function local_accounts_filter_reset() {
        $this->reset('search_user_name', 'search_user_username', 'search_user_email', 'search_user_authorization_level', 'search_user_status_id');
        $this->resetPage();
        $this->dispatch('refresh_local_accounts_mount');
    }

    public function mount() {
        $this->statuses = Status::all();

        $this->accountAuthorizationLevels = AccountAuthorizationLevel::all();
    }

    public function filter_users() {
        return User::where(
            'is_local',
            true
        )->when(
            isset($this->search_user_name) && !empty($this->search_user_name),
            function ($query) {
                return $query->where('name', 'REGEXP', $this->search_user_name);
            }
        )->when(
            isset($this->search_user_username) && !empty($this->search_user_username),
            function ($query) {
                return $query->where('username', 'REGEXP', $this->search_user_username);
            }
        )->when(
            isset($this->search_user_email) && !empty($this->search_user_email),
            function ($query) {
                return $query->where('email', '=', $this->search_user_email);
            }
        )->when(
            isset($this->search_user_authorization_level) && !empty($this->search_user_authorization_level),
            function ($query) {
                $level = AuthorizationLevelService::AUTH_LEVELS[$this->search_user_authorization_level];

                return $query->whereRaw('auth_level & ? = ?', [$level, $level]);
            }
        )->when(
            isset($this->search_user_status_id) && !empty($this->search_user_status_id),
            function ($query) {
                return $query->where('status_id', '=', $this->search_user_status_id);
            }
        )->paginate(10);
    }

    public function render() {
        return view('livewire.admin.local-accounts', [
            'local_accounts' => $this->filter_users()
        ])->layout('layouts.admin');
    }
}
