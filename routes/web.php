<?php

use App\Livewire\Candidate\Exam\Assessment;
use App\Livewire\Candidate\Exam\AssessmentInstructions;
use App\Livewire\Candidate\Exam\CandidateAssessment;
use App\Livewire\Candidate\Exam\CandidateOral;
use App\Livewire\Candidate\Exam\CandidatePractical;
use App\Livewire\Candidate\Exam\OralCode;
use App\Livewire\Candidate\Exam\PracticalCode;
use App\Livewire\Candidate\Home;
use App\Livewire\Candidate\Login;
use App\Livewire\Exam\OralScheduledQuestions;
use App\Livewire\Exam\OralScheduledQuestionsUpdate;
use App\Livewire\Exam\PracticalScheduledScenarios;
use App\Livewire\Exam\PracticalScheduledScenariosUpdate;
use App\Livewire\References\Scoresheets\OralScoring;
use App\Livewire\References\Scoresheets\PracticalScoring;
use App\Livewire\Scores\AssessmentScores;
use App\Livewire\Scores\CandidateCompetency;
use App\Livewire\Scores\OralScores;
use App\Livewire\Scores\PracticalScores;
use App\Livewire\Settings\CandidateList;
use App\Livewire\Exam\Assessmentlist;
use App\Livewire\Exam\Interviewlist;
use App\Livewire\Exam\Practicallist;
use App\Livewire\References\Criterias\Oral;
use App\Livewire\References\Criterias\Practical;
use App\Livewire\References\Offices;
use App\Livewire\References\Positions;
use App\Livewire\References\Skills;
use App\Livewire\References\Venues;
use App\Livewire\Reports\AdminReports;
use App\Livewire\Reports\CandidateReports;
use App\Livewire\Test\Assessment\AddQuestions;
use App\Livewire\Test\Assessment\UpdateQuestions;
use App\Livewire\Test\Assessment\ViewQuestions;
use App\Livewire\Test\Oral\AddOralQuestions;
use App\Livewire\Test\Oral\UpdateOralQuestions;
use App\Livewire\Test\Oral\ViewOralQuestions;
use App\Livewire\Test\Practical\AddScenarios;
use App\Livewire\Test\Practical\UpdateScenarios;
use App\Livewire\Test\Practical\ViewScenarios;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\Eval\AssessmentNotes;
use App\Livewire\Eval\OralTestEvaluation;
use App\Livewire\Eval\PracticalTestEvaluation;
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
use Illuminate\Http\Request;

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
    Route::get('/test/assessmenttests', AssessmentTest::class)->name('test.assessment');
    Route::get('/test/practicalexams', PracticalExam::class)->name('test.practical');
    Route::get('/test/oralinterveiws', OralInterview::class)->name('test.interview');
    Route::get('/eval/assessmentnotes', AssessmentNotes::class)->name('eval.assessmentnotes');
    Route::get('/eval/ptestevaluation', PracticalTestEvaluation::class)->name('eval.ptestevaluations');
    Route::get('/eval/otestevaluation', OralTestEvaluation::class)->name('eval.otestevaluations');
    Route::get('/logs', Logs::class)->name('logs');
    Route::get('/reports', Reports::class)->name('reports');
    Route::get('/permissions', Permissions::class)->name('permissions');
    Route::get('/reports/adminreports', AdminReports::class)->name('reports.adminreports');
    Route::get('/reports/candidatereports', CandidateReports::class)->name('reports.candidatereports');
    Route::get('/exam/assessmentlist', Assessmentlist::class)->name('exam.assessmentlist');
    Route::get('/exam/practicallist', Practicallist::class)->name('exam.practicallist');
    Route::get('/exam/interviewlist', Interviewlist::class)->name('exam.interviewlist');
    Route::get('/exam/practical-scheduled-scenarios/{newAssignedId}', PracticalScheduledScenarios::class)->name('exam.practicalscheduledscenarios');
    Route::get('/exam/practical-scheduled-scenarios-update/{AssignedId}', PracticalScheduledScenariosUpdate::class)->name('exam.practicalscheduledscenariosupdate');
    Route::get('/exam/oral-scheduled-scenarios/{newAssignedId}', OralScheduledQuestions::class)->name('exam.oralscheduledquestions');
    Route::get('/exam/oral-scheduled-scenarios-update/{AssignedId}', OralScheduledQuestionsUpdate::class)->name('exam.oralscheduledquestionsupdate');
    Route::get('/references/criterias/practical', Practical::class)->name('references.criterias.practical');
    Route::get('/references/criterias/oral', Oral:: class)->name('references.criterias.oral');
    Route::get('/references/scoresheets/practical', PracticalScoring::class)->name('references.scoresheets.practical');
    Route::get('/references/scoresheets/oral', OralScoring::class)->name('references.scoresheets.oral');
    Route::get('/scores/assessment', AssessmentScores::class )->name('scores.assessment');
    Route::get('/scores/practical', PracticalScores::class)->name('scores.practical');
    Route::get('/scores/oral', OralScores::class)->name('scores.oral');
    Route::get('/scores/candidatecompetency', CandidateCompetency::class)->name('scores.candidatecompetency');
    Route::get('/test/assessment/addquestions', AddQuestions::class)->name('test.assessment.addquestions');
    Route::get('/test/assessment/updatequestions', UpdateQuestions::class)->name('test.assessment.updatequestions');
    Route::get('/test/assessment/viewquestions', ViewQuestions::class)->name('test.assessment.viewquestions');
    Route::get('/test/practical/addscenarios', AddScenarios::class)->name('test.practical.addscenarios');
    Route::get('/test/practical/updatescenarios', UpdateScenarios::class)->name('test.practical.updatescenarios');
    Route::get('/test/practical/viewscenarios', ViewScenarios::class)->name('test.practical.viewscenarios');
    Route::get('/test/oral/addoralquestions', AddOralQuestions::class)->name('test.oral.addoralquestions');
    Route::get('/test/oral/updateoralquestions', UpdateOralQuestions::class)->name('test.oral.updateoralquestions');
    Route::get('/test/oral/vieworalquestions', ViewOralQuestions::class)->name('test.oral.vieworalquestions');
});

Route::get('/candidate/login', Login::class)->name('candidate.login');
Route::get('/candidate/home', Home::class)->name('candidate.home');
Route::get('/candidate/exam/assessment', CandidateAssessment::class)->name('candidate.exam.assessment');
Route::get('/candidate/exam/practical', CandidatePractical::class)->name('candidate.exam.practical');
Route::get('/candidate/exam/oral', CandidateOral::class)->name('candidate.exam.oral');
Route::get('/candidate/exam/assessment-instructions', AssessmentInstructions::class)->name('candidate.exam.assessmentinstructions');
Route::get('/candidate/exam/practical-code', PracticalCode::class)->name('candidate.exam.practicalcode');
Route::get('/candidate/exam/oral-code', OralCode::class)->name('candidate.exam.oralcode');

Route::post('/candidate-logout', function (Request $request) {
    $request->session()->forget(['candidate_id', 'candidate_name']); 
    return redirect()->route('candidate.login'); 
})->name('candidate.logout');