<?php

use App\Livewire\Candidate\AddCandidate;
use App\Livewire\Candidate\CandidateList;
use App\Livewire\References\Offices;
use App\Livewire\References\Positions;
use App\Livewire\References\Skills;
use App\Livewire\References\Venues;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\References\EvaluationCriterias;
use App\Livewire\References\PriorityGroups;
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
    Route::get('/references/venues', Venues::class)->name('references.venues');
    Route::get('/references/offices', Offices::class)->name('references.offices');
    Route::get('/references/criterias', EvaluationCriterias::class)->name('references.criterias');
    Route::get('/references/prioritygroups', PriorityGroups::class)->name('references.prioritygroups');
    Route::get('/candidate/list', CandidateList::class)->name('candidate.list');
    Route::get('/candidate/add', AddCandidate::class)->name('candidate.add');
});