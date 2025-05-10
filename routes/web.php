<?php

use App\Livewire\InitialSetup;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('initial-setup', InitialSetup::class);
Route::view('/', 'welcome');

Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');
    Route::view('profile', 'profile')
        ->name('profile');

    Route::middleware([IsAdmin::class])->group(function () {
        Route::get('app-configuration', InitialSetup::class)
            ->name('app-configuration');
    });
});





require __DIR__ . '/auth.php';
