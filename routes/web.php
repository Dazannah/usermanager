<?php

use App\Livewire\Setup\InitialSetup;
use App\Http\Middleware\IsAdmin;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\Authorizations;
use App\Livewire\Admin\Locations;
use App\Livewire\Setup\Setup;
use Illuminate\Support\Facades\Route;

Route::get('initial-setup', InitialSetup::class);
Route::get('/', fn() => redirect('/login'));

Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');
    Route::view('profile', 'profile')
        ->name('profile');

    Route::middleware([IsAdmin::class])->prefix('admin')->group(function () {
        Route::get('/', AdminDashboard::class)
            ->name('admin-dashboard');

        Route::get('/authorizations', Authorizations::class)
            ->name('admin-authorizations');

        Route::get('/locations', Locations::class)
            ->name('admin-locations');

        Route::get('/app-configuration', Setup::class)
            ->name('admin-app-configuration');
    });
});

require __DIR__ . '/auth.php';
