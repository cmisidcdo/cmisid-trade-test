<?php

namespace App\Livewire\Candidate\Exam;

use App\Models\AssignedOral;
use App\Models\Candidate;
use App\Models\Venue;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Log;

class CandidateOral extends Component
{
    public $oral, $candidate, $venue;

    public function mount()
    {
        try {
            $candidateId = Session::get('candidate_id');
            
            $assignedOral = AssignedOral::where('candidate_id', $candidateId)
                ->with('oralScore.oralScoreSkills.oralScoreSkillQuestions.oral_questions')
                ->first();

            $candidate = Candidate::where('id',$candidateId)->first();
            $this->candidate = $candidate;
            if (!$assignedOral) {
                Log::warning('AssignedOral not found for candidate_id: ' . $candidateId);
                abort(404, 'Assigned assessment not found.');
            }
    
            Log::info('AssignedOral fetched successfully', ['assignedOral' => $assignedOral]);
    
            $this->oral = $assignedOral;
    
        } catch (\Exception $e) {
            Log::error('Error fetching AssignedOral: ' . $e->getMessage(), [
                'candidate_id' => $candidateId ?? null,
            ]);
            abort(500, 'Something went wrong.');
        }
        $venue = Venue::find($assignedOral->venue_id)->first();
        $this->oral = $assignedOral;
        $this->venue = $venue;
       
    }

    public function render()
    {
        return view('livewire.candidate.exam.candidate-oral')->layout('components.layouts.candidate-exam');
    }

    public function goBack()
    {
        $this->dispatch('go-back');
    }

}
