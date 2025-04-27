<?php

namespace App\Livewire\Candidate\Exam;

use App\Models\AssignedPractical;
use App\Models\Candidate;
use App\Models\Venue;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Log;

class CandidatePractical extends Component
{
    public $practical, $candidate, $venue;

    public function mount()
    {
        try {
            $candidateId = Session::get('candidate_id');
            
            $assignedPractical = AssignedPractical::where('candidate_id', $candidateId)
                ->with('practicalScore.practicalScoreSkills.practicalScoreSkillScenarios.practical_scenarios')
                ->first();

            $candidate = Candidate::where('id',$candidateId)->first();
            $this->candidate = $candidate;
            if (!$assignedPractical) {
                Log::warning('AssignedPractical not found for candidate_id: ' . $candidateId);
                abort(404, 'Assigned assessment not found.');
            }
    
            Log::info('AssignedPractical fetched successfully', ['assignedPractical' => $assignedPractical]);
    
            $this->practical = $assignedPractical;
    
        } catch (\Exception $e) {
            Log::error('Error fetching AssignedPractical: ' . $e->getMessage(), [
                'candidate_id' => $candidateId ?? null,
            ]);
            abort(500, 'Something went wrong.');
        }
        $venue = Venue::find($assignedPractical->venue_id)->first();
        $this->practical = $assignedPractical;
        $this->venue = $venue;
       
    }
    public function render()
    {
        return view('livewire.candidate.exam.candidate-practical')->layout('components.layouts.candidate-exam');
    }

    public function goBack()
    {
        $this->dispatch('go-back');
    }
}
