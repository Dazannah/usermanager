<?php

use App\Livewire\InitialSetup;
use App\Http\Middleware\IsAdmin;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\Authorizations;
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

        Route::get('app-configuration', InitialSetup::class)
            ->name('admin-app-configuration');
    });
});

require __DIR__ . '/auth.php';
