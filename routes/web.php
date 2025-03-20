<?php

use App\Livewire\Candidate\AddCandidate;
use App\Livewire\Candidate\CandidateList;
use App\Livewire\Candidate\UpdateCandidate;
use App\Livewire\References\Offices;
use App\Livewire\References\Positions;
use App\Livewire\References\Skills;
use App\Livewire\References\Venues;
use App\Livewire\Reports\AdminReports;
use App\Livewire\Reports\CandidateReports;
use App\Livewire\Test\CreateSchedule;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\Exam\AssessmentNotes;
use App\Livewire\Exam\AssignExam;
use App\Livewire\Exam\OralTestEvaluation;
use App\Livewire\Exam\PracticalTestEvaluation;
use App\Livewire\Logs;
use App\Livewire\Permissions;
use App\Livewire\Reports;
use App\Livewire\References\EvaluationCriterias;
use App\Livewire\References\PriorityGroups;
use App\Livewire\Settings\Users;
use App\Livewire\Test\AssessmentTest;
use App\Livewire\Test\OralInterview;
use App\Livewire\Test\PracticalExam;
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
    Route::get('/candidate/update', UpdateCandidate::class)->name('candidate.update');
    Route::get('/test/assessmenttests', AssessmentTest::class)->name('test.assessment');
    Route::get('/test/practicalexams', PracticalExam::class)->name('test.practical');
    Route::get('/test/oralinterveiws', OralInterview::class)->name('test.interview');
    Route::get('/exam/assign', AssignExam::class)->name('assign.exam');
    Route::get('/exam/assessmentnotes', AssessmentNotes::class)->name('exam.assessmentnotes');
    Route::get('/exam/ptestevaluation', PracticalTestEvaluation::class)->name('exam.ptestevaluations');
    Route::get('/exam/otestevaluation', OralTestEvaluation::class)->name('exam.otestevaluations');
    Route::get('/logs', Logs::class)->name('logs');
    Route::get('/reports', Reports::class)->name('reports');
    Route::get('/permissions', Permissions::class)->name('permissions');
    Route::get('/reports/adminreports', AdminReports::class)->name('reports.adminreports');
    Route::get('/reports/candidatereports', CandidateReports::class)->name('reports.candidatereports');
    Route::get('/test/createschedule', CreateSchedule::class)->name('test.createschedule');
});