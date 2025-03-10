<?php

use App\Livewire\References\Positions;
use App\Livewire\References\Skills;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\Settings\Users;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard',Dashboard::class)->name('dashboard');
    Route::get('/settings/users',Users::class)->name('settings.users');
    Route::get('/references/skills',Skills::class)->name('references.skills');
    Route::get('/references/positions', Positions::class)->name('references.positions');
});