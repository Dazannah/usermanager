<?php

use App\Livewire\InitialSetup;
use Illuminate\Support\Facades\Route;

Route::get('initial-setup', InitialSetup::class);

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
