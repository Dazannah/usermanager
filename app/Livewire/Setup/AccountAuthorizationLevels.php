<?php

namespace App\Livewire\Setup;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\AccountAuthorizationLevel;
use Illuminate\Database\Eloquent\Collection;

class AccountAuthorizationLevels extends Component {
    use WithPagination;

    /** @var Collection<int,AccountAuthorizationLevel> */
    protected Collection $accountAuthorizationLevels;

    //filter properties
    #[Url(as: 'technical_name')]
    public string $name;
    #[Url(as: 'displayName')]
    public string $displayName;
    #[Url(as: 'ldapGroupName')]
    public string $ldap_group_name;

    public $listeners = ['authorizations_levels_filter_reset', 'refresh_authorizations_levels_mount'];

    public function refresh_authorizations_levels_mount() {
    }

    public function authorizations_levels_filter_reset() {
        $this->reset('name', 'displayName', 'ldap_group_name');
        $this->resetPage();
    }

    //search
    public function filter_account_authorizations() {
        return AccountAuthorizationLevel::when(
            isset($this->name) && !empty($this->name),
            function ($query) {
                return $query->where('name', 'REGEXP', $this->name);
            }
        )->when(
            isset($this->displayName) && !empty($this->displayName),
            function ($query) {
                return $query->where('displayName', 'REGEXP', $this->displayName);
            }
        )->when(
            isset($this->ldap_group_name) && !empty($this->ldap_group_name),
            function ($query) {
                return $query->where('ldap_group_name', 'REGEXP', $this->ldap_group_name);
            }
        )->paginate(10);
    }

    public function render() {
        return view('livewire.setup.account-authorization-levels', [
            'accountAuthorizationLevels' => $this->filter_account_authorizations()
        ])->layout('layouts.admin');
    }
}
