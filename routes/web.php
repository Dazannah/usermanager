<?php

use App\Livewire\Setup\Setup;
use App\Livewire\Setup\Texts;
use App\Http\Middleware\IsSysAdmin;
use App\Livewire\Admin\Locations;
use App\Livewire\Admin\Departments;
use App\Livewire\Setup\InitialSetup;
use App\Livewire\Admin\LocalAccounts;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\Authorizations;
use App\Livewire\Setup\AccountAuthorizationLevels;
use App\Livewire\Setup\LocalAccountSessions;
use App\Livewire\User\CreateNewUserRequest;

Route::get('initial-setup', InitialSetup::class);
Route::get('/', fn() => redirect('/login'));

Route::middleware(['auth', 'isLocalUserEnabled'])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    Route::get('/create-new-user-request', CreateNewUserRequest::class)
        ->name('create-new-user-request');

    Route::view('profile', 'profile')
        ->name('profile');

    Route::middleware([IsSysAdmin::class])->prefix('admin')->group(function () {
        Route::get('/', AdminDashboard::class)
            ->name('admin-dashboard');

        Route::get('/authorizations', Authorizations::class)
            ->name('admin-authorizations');

        Route::get('/locations', Locations::class)
            ->name('admin-locations');

        Route::get('/departments', Departments::class)
            ->name('admin-departments');

        Route::get('/app-configuration', function () {
            return redirect()->route('admin-app-configuration-general');
        })->name('admin-app-configuration');

        if (config('app.is_local_account_enabled'))
            Route::get('/local-accounts', LocalAccounts::class)
                ->name('admin-app-configuration-local-accounts');

        Route::prefix('app-configuration')->group(function () {
            Route::get('/general', Setup::class)
                ->name('admin-app-configuration-general');

            Route::get('/texts', Texts::class)
                ->name('admin-app-configuration-texts');

            Route::get('/authorization-levels', AccountAuthorizationLevels::class)
                ->name('admin-app-configuration-authorization-levels');

            Route::get('/local-account-sessions', LocalAccountSessions::class)
                ->name('admin-app-configuration-local-account-sessions');
        });
    });
});

require __DIR__ . '/auth.php';
