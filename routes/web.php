<?php

use App\Livewire\InitialSetup;
use App\Http\Middleware\IsAdmin;
use App\Livewire\Admin\AdminDashboard;
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
        Route::get('app-configuration', InitialSetup::class)
            ->name('app-configuration');
    });
});

require __DIR__ . '/auth.php';
