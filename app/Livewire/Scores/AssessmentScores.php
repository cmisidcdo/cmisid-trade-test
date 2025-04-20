<?php

namespace App\Livewire\Scores;

use App\Models\AssignedAssessment;
use App\Models\Candidate;
use App\Models\Venue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str; 
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use App\Models\AssessmentScore;
use App\Models\Position;
use App\Models\AssessmentScoreSkill;
use App\Models\PositionSkill;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentScoreSkillQuestion;


class AssessmentScores extends Component
{
    public $editMode;

    public $archive = false;

    public $search;
    public $filterStatus = 'all'; 
    public $title, $skill_id, $status;
    public $assigned_date, $assessmentScores, $assigned_time, $venue_id, $candidate_id, $candidate_name, $access_code, $draft_status = 'draft';

    public $venues = [];
    public $selectedcandidate;

    public function render()
    {
        return view('livewire.scores.assessment-scores', [
            'assessmentscores' => $this->loadAssessmentScores(),         
        ]);
    }

    public function loadAssessmentScores()
    {
        return AssessmentScore::with('candidate')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhereHas('candidate', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->filterStatus !== 'all', function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderByDesc('created_at')
            ->paginate(10);
    }

}
