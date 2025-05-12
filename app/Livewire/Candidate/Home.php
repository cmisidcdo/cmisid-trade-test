<?php

namespace App\Livewire\Candidate;

use Livewire\Component;
use App\Models\AssignedAssessment;
use App\Models\AssignedPractical;
use App\Models\AssessmentScore;
use App\Models\PracticalScore;
use App\Models\AssignedOral;
use App\Models\Candidate;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\AQChoice;
use Illuminate\Support\Facades\Log;

class Home extends Component
{
    public $assessmentCompleted = false;
    public $practicalCompleted = false;

    public $practical_code, $interview_code;
    public function mount()
    {
        $candidateId = Session::get('candidate_id');

        if ($candidateId) {
            $assignedAssessment = AssignedAssessment::where('candidate_id', $candidateId)->first();

            if ($assignedAssessment) {
                $assessmentScore = AssessmentScore::where('assigned_assessment_id', $assignedAssessment->id)->first();

                if ($assessmentScore && $assessmentScore->status === 'done') {
                    $this->assessmentCompleted = true;
                }
            }

            $assignedPractical = AssignedPractical::where('candidate_id', $candidateId)->first();

            if ($assignedPractical) {
                $practicalScore = PracticalScore::where('assigned_practical_id', $assignedPractical->id)->first();

                if ($practicalScore && $practicalScore->status === 'done') {
                    $this->practicalCompleted = true;
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.candidate.home', [
            'assessment_completed' => $this->assessmentCompleted,
            'practical_completed' => $this->practicalCompleted,
        ])->layout('components.layouts.candidate-app');
    }

    public function proceedToTest()
    {
        $this->dispatch('openTestInNewTab');
    }
}
